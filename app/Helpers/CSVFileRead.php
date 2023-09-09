<?php

namespace App\Helpers;

use App\Models\Contact;

class CSVFileRead{
    public static function readCSV($request){
        try {
            // Validate the incoming request
            $request->validate([
                'csv_file' => 'required|mimes:csv,txt|max:2048', // Adjust validation rules as needed
            ]);

            // Store the uploaded CSV file
            $file = $request->file('csv_file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);

            // Process the uploaded CSV file or save its details to the database
            $filePath = public_path('uploads') . '/' . $fileName;
            $csv = new \SplFileObject($filePath, 'r');
            
            $header = $csv->fgetcsv();

            $contacts = [];
            
            // Read the contacts rows
            while (!$csv->eof()) {
                $row = $csv->fgetcsv();
                if ($row) {
                    $contacts[] = array_combine($header, $row);
                }
            }
            
            try {
                foreach($contacts as $contact){
                    Contact::create(
                        [
                            'first_name'=> $contact['first_name'],
                            'last_name'=> $contact['last_name'],
                            'email'=> $contact['email'],
                            'phone_number'=> $contact['phone_number'],
                            'status'=> 1
                        ]
                    );
                }
                return "Data seeded into database successfully";
            } 
            catch (\Exception $ex) {
                return $ex->getMessage();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}