<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Beta\Microsoft\Graph\Model\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\TimeZones\TimeZones;

class CalendarController extends Controller
{
    public function calendar()
    {
        $viewData = $this->loadViewData();

        $graph = $this->getGraph();
        // Get user's timezone
        $timezone = TimeZones::getTzFromWindows($viewData['userTimeZone']);

        // Get start and end of week
        $startOfWeek = new \DateTimeImmutable('sunday -1 week', $timezone);
        $endOfWeek = new \DateTimeImmutable('sunday', $timezone);

        $viewData['dateRange'] = $startOfWeek->format('M j, Y') . ' - ' . $endOfWeek->format('M j, Y');

        $queryParams = array(
            'startDateTime' => $startOfWeek->format(\DateTimeInterface::ISO8601),
            'endDateTime' => $endOfWeek->format(\DateTimeInterface::ISO8601),
            // Only request the properties used by the app
            '$select' => 'subject,organizer,start,end',
            // Sort them by start time
            '$orderby' => 'start/dateTime',
            // Limit results to 25
            '$top' => 25
        );

        // Append query parameters to the '/me/calendarView' url
        $getEventsUrl = '/me/calendarView?' . http_build_query($queryParams);

        $events = $graph->createRequest('GET', $getEventsUrl)
            // Add the user's timezone to the Prefer header
            ->addHeaders(
                array(
                'Prefer' => 'outlook.timezone="' . $viewData['userTimeZone'] . '"'
                )
            )
            ->setReturnType(Model\Event::class)
            ->execute();

        $viewData['events'] = $events;
        return view('calendar', $viewData);
    }

    public function getNewEventForm()
    {
        $viewData = $this->loadViewData();

        return view('newevent', $viewData);
    }

    public function createNewEvent(Request $request)
    {
        // Validate required fields
        $request->validate(
            [
            'eventSubject' => 'nullable|string',
            'eventAttendees' => 'nullable|string',
            'eventStart' => 'required|date',
            'eventEnd' => 'required|date',
            'eventBody' => 'nullable|string'
            ]
        );

        $viewData = $this->loadViewData();

        $graph = $this->getGraph();

        // Attendees from form are a semi-colon delimited list of
        // email addresses
        $attendeeAddresses = explode(';', $request->eventAttendees);

        // The Attendee object in Graph is complex, so build the structure
        $attendees = [];
        foreach ($attendeeAddresses as $attendeeAddress) {
            $attendees[] = [
                // Add the email address in the emailAddress property
                'emailAddress' => [
                    'address' => $attendeeAddress
                ],
                // Set the attendee type to required
                'type' => 'required'
            ];
        }

        // Build the event
        $newEvent = [
            'subject' => $request->eventSubject,
            'attendees' => $attendees,
            'start' => [
                'dateTime' => $request->eventStart,
                'timeZone' => $viewData['userTimeZone']
            ],
            'end' => [
                'dateTime' => $request->eventEnd,
                'timeZone' => $viewData['userTimeZone']
            ],
            'body' => [
                'content' => $request->eventBody,
                'contentType' => 'text'
            ]
        ];

        // POST /me/events
        $response = $graph->createRequest('POST', '/me/events')
            ->attachBody($newEvent)
            ->setReturnType(Model\Event::class)
            ->execute();

        return $response;
    }


    private function getGraph(): Graph
    {
        // Get the access token from the cache
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();

        // Create a Graph client
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        return $graph;
    }

    public function postEventToCalendar($id)
    {

        $tenantId = env('AZURE_TENANT_ID');
        $clientId = env('AZURE_CLIENT_ID');
        $clientSecret = env('AZURE_CLIENT_SECRET');

        $guzzle = new \GuzzleHttp\Client();

        $url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/v2.0/token';

        $token = json_decode(
            $guzzle->post(
                $url, [
                'form_params' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'scope' => 'https://graph.microsoft.com/.default',
                'grant_type' => 'client_credentials',
                ],
                ]
            )->getBody()->getContents()
        );

        $accessToken = $token->access_token;
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        // Get users data from Azure AD
        $url = '/users?$select=id,mail';

        $headers = ['ConsistencyLevel' => 'eventual'];


        $userArray = [];
        $userIterator = $graph->createCollectionRequest("GET", $url)
            ->setReturnType(Model\User::class)
            ->setPageSize(999)
            ->addHeaders($headers);

        $userIterators = $userIterator->getPage();

        foreach ($userIterators as $doc) {
            $userArray[] = $doc;
        }

        $data = json_encode($userArray);
        $result = json_decode($data, true);

        $reservationData = \App\Models\Reservation::where('id', $id)->first();
        $userData = \App\Models\User::where('id', $reservationData->user_id)->first();
        $workspaceData = \App\Models\Workspace::where('id', $reservationData->workspace_id)->first();
        $zoneData = \App\Models\Zone::where('id', $workspaceData->zone_id)->first();

        $userID = '';

        foreach ($result as $item) {
            if ($userData->email === $item['mail']) {
                $userID = $item['id'];

                $event = [
                    'Subject' => 'Workspace reservation: ' . $workspaceData->tableNumber,
                    'Body' => [
                        'ContentType' => 'HTML',
                        'Content' => 'Workspace reservation at ' . $zoneData->description,
                    ],
                    'Start' => [
                        'DateTime' => $reservationData->dateFrom,
                        'TimeZone' => 'UTC',
                    ],
                    'End' => [
                        'DateTime' => $reservationData->dateTo,
                        'TimeZone' => 'UTC',
                    ],
                    'showAs' => 'Free'
                ];

                $url = "/users/" . $userID . "/events";

                // Post reservation event (meeting) to user's calendar
                $response = $graph->createRequest('POST', $url)
                    ->attachBody($event)
                    ->setReturnType(Model\Event::class)
                    ->execute();

                return $response;
            }

        }
        return false;

    }
}
