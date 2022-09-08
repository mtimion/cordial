<?php

namespace App\Http\Controllers;

use App\Classes\BirthdayHelper;
use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class PeopleController extends Controller
{
    public function getAll(): JsonResponse
    {

        try {
            $people = Person::all();
            $output = ['data' => []];


            foreach ($people as $person) {
                $helper = new BirthdayHelper($person);

                $person['birthdate'] = $helper->getBirthdate()->format('Y-m-d'); //Converts back to person's time zone for ease of use.
                $person['isBirthday'] = $helper->isBirthdayToday();
                $person['interval'] = $helper->isBirthdayToday()? $helper->getIntervalUntilTomorrow() : $helper->getInterval();
                $person['message'] = $helper->getIntervalMessage($person['name']);


                $output['data'][] = $person;
            }
            return response()->json($output);
        } catch (\Exception $e) {
            print_r($e->getMessage());
            return response()->json(['error' => 'Error fetching results.']);
        }
    }

    public function createPerson(Request $request): JsonResponse
    {

        $this->validate($request, [
            'name' => 'required',
            'birthdate' => 'required|date',
            'timezone' => 'required|timezone'
        ], [
            'birthday' => 'The birthday field is required, and should be in the a validate date',
            'timezone' => 'Timezone is required and must be a valid timezone identifier according to the timezone_identifiers_list PHP function'
        ]);

        try{
            //change date to UTC for consistent storage
            $data = $request->all();

            $carbon = Carbon::parse($data['birthdate'] . ' ' . $data['timezone']); //create carbon on inputted time
            $carbon->tz('UTC'); //convert to UTC for storage

            $data['birthdate'] = $carbon->format('Y-m-d H:i:s'); //store in standard format as UTC*/
            Person::query()->create($data);

            return response()->json(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'There was an error creating the record.']);
        }


    }
}