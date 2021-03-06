<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Country;
use App\City;
use App\Address;
use App\Company;
use App\RetailStore;
use App\Role;
use App\Contract;
use App\Employee;
use App\Category;
use App\CalendarEvent;


class DatabaseSeeder extends Seeder
{


    /* ------------------------------------- ROLES ------------------------------------ */
    public function addRoles()
    {
        $roleArray = array(
            'Cashier',
            'Stockman',
            'Office Worker',
        );

        foreach ($roleArray as $roleName) {
            Role::create(array(
                'name' => $roleName,
            ));
        }
    }


    /* ------------------------------------- CATEGORY ------------------------------------ */
    public function addCategorys()
    {
        /* ORDER OF CATEGORY VERY IMPORTANT FOR SEEDS BECAUSE OF ID */
        /** 1   = Work
         *  2   = Work Final
         *  3-4 = Illness / Vacation can get accepted
         *  5-8 = Else
         **/

        $categoryArray = array(
            'Work' => 'blue-event',
            'Work Final' => 'blue-event',
            'Illness' => 'red-event',
            'Vacation' => 'yellow-event',
            'Study' => 'orange-event',
            'Training' => 'green-light-event',
            'Seminar' => 'green-event',
            'Private' => 'grey-event'
        );

        foreach ($categoryArray as $key => $value) {
            Category::create(array(
                'name' => $key,
                'color' => $value,
            ));
        }
    }


    /* ------------------------------------- ADDRESS ------------------------------------ */
    public function addAddress($street, $nr, $postcode, $cityName, $countryName)
    {

        $thisCountry = Country::firstOrCreate(array(
            'name' => $countryName,
        ));

        $thisCity = City::firstOrCreate(array(
            'name' => $cityName,
            'country_id' => $thisCountry->id,
        ));


        return Address::create(array(
            'street' => $street,
            'street_nr' => $nr,
            'postcode' => $postcode,
            'city_id' => $thisCity->id,
        ));
    }


    /* ------------------------------------- COMPANY ------------------------------------ */
    public function addCompanies($companyName, $forename, $surname, $address)
    {
        if ($surname == 'Maier') {
            $email = 'admin@web.de';
        } else {
            $email = $forename . '.' . $surname . '@web.de';
        }

        $thisAdmin = Admin::create(array(
            'forename' => $forename,
            'name' => $surname,
            'email' => $email,
            'password' => bcrypt('123456')
        ));

        Company::create(array(
            'name' => $companyName,
            'admin_id' => $thisAdmin->id,
            'address_id' => $address->id
        ));
    }


    /* ------------------------------------- RETAIL Store ------------------------------------ */
    public function addRetailStore($storeAddress)
    {
        $amountOfCompanys = DB::table('company')->count();

        $thisStoreAddress = DB::table('address')
            ->select('address.street', 'city.name')
            ->join('city', 'city.id', '=', 'address.city_id')
            ->where('address.id', $storeAddress->id)
            ->get()[0];

        RetailStore::create(array(
            'name' => $thisStoreAddress->name . ' ' . $thisStoreAddress->street,
            'company_id' => rand(1, $amountOfCompanys),
            'address_id' => $storeAddress->id
        ));
    }


    /* ------------------------------------- EMPLOYEE ------------------------------------ */
    public function addEmployee($forename, $surname)
    {
        $amountOfStores = DB::table('retail_store')->count();

        // Contract
        $workingHours = rand(2, 9) * 5;
        $classification = 'Temporary Help';
        if ($workingHours <= 15) {
            $classification = 'Temporary Help';
        } elseif ($workingHours <= 25) {
            $classification = 'Student Employee';
        } elseif ($workingHours <= 35) {
            $classification = 'Part Time';
        } elseif ($workingHours <= 25) {
            $classification = 'Full Time';
        }

        $periodOfAgrArray = array('unlimitted', 'limitted');

        $thisContract = Contract::create(array(
            'period_of_agreement' => $periodOfAgrArray[rand(0, 1)],
            'working_hours' => $workingHours,
            'classification' => $classification,
            'role_id' => rand(1, 3),
        ));

        if ($surname == 'Buhl') {
            $email = 'emp@web.de';
        } else {
            $email = $forename . '.' . $surname . '@web.de';
        }

        /* Hoehere Wahscheinlichkeit fuer store 1 */
        if (rand(0, 1) == 0) {
            $retailStoreId = 1;
        } else {
            $retailStoreId = rand(1, $amountOfStores);
        }

        Employee::create(array(
            'forename' => $forename,
            'name' => $surname,
            'email' => $email,
            'password' => bcrypt('123456'),
            'retail_store_id' => $retailStoreId,
            'contract_id' => $thisContract->id
        ));
    }

    /* ------------------------------------- EVENTS ------------------------------------ */
    function addCalendarEvents()
    {
        $allEmployees = DB::table('employees')
            ->get();

        $nextNextSunnday = 14 - (new DateTime())->format('N');


        // alle Employees
        foreach ($allEmployees as $emp) {

            // 7 tage zurueck und bis zum uebernaechsten Sonntag
            for ($day = -7; $day < $nextNextSunnday + 7; $day++) {


                $DBdate = ((new DateTime())->modify($day . ' days'))->format('Y-m-d');

                // Seltener Allday-Event
                if (($day + rand(-3, 3)) % rand(2, 5) == 0) {

                    $this->addAlldayEvents($day, $DBdate, $emp);

                } // Oefter Time-Event
                else {

                    $this->addTimeEvents($day, $DBdate, $emp, $nextNextSunnday);
                }
            }
        }

    }


    function addAlldayEvents($day, $DBdate, $emp)
    {
        // Category ID
        // wenn in vergangenheit
        if ($day <= 1) {
            // Illness / Vacation / Else Categorys
            $cat = rand(3, 8);
        } else {
            // Vacation / Else Category
            $cat = rand(4, 8);
        }

        // Normalerweise bei Events kein accepted
        $accepted = false;

        // Bei Illness und Vacation manchmal schon akzeptiert
        if (($cat == 3 || $cat == 4) && rand(0, 1) == 0) {
            $accepted = true;
        }

        // Create Allday Event
        CalendarEvent::create(array(
            'date' => $DBdate,
            'from' => '',
            'to' => '',
            'accepted' => $accepted,
            'employee_id' => $emp->id,
            'category_id' => $cat,
        ));
    }

    function getHoursArray()
    {
        // Randomize start / end time
        $time = array(
            rand(8, 15),
            rand(16, 22),
            rand(8, 11),
            rand(12, 15),
            rand(16, 18),
            rand(19, 22)
        );

        // Null vor Stunden, wenn Einer-Zahl
        for ($t = 0; $t < 6; $t++) {
            if ($time[$t] <= 9) {
                $time[$t] = "0" . $time[$t];
            }
        }
        return $time;
    }

    function getCategoryForTimeEvent($day)
    {
        // another category (except Vacation) OR Work
        if (($day + rand(-3, 3)) % rand(2, 5) == 0) {

            // Illness (Category==3) nur wenn in vergangenheit
            if ($day <= 1) {

                // 1/5 wenn Illness
                if (rand(0, 4) == 0) {
                    $cat = 3;
                    // 4/5 else
                } else {
                    $cat = rand(5, 8);
                }
            } else {
                $cat = rand(5, 8);
            }
        } else {
            $cat = 1;
        }

        return $cat;
    }

    function addTimeEvents($day, $DBdate, $emp, $nextNextSunnday)
    {
        $time = $this->getHoursArray();

        // Normalerweise 1 Durchlauf -> 1 Event am Tag
        $i = 0;

        //zufalls-Variable speichern
        $bool = ($day + rand(-3, 3)) % rand(4, 5) == 0;

        // Seltener 2 Durchlauufe -> 2 Events am Tag
        if ($bool) {
            $i = 2;
        }

        // Falls mehrere Events an einem Tag
        while ($i < 6) {

            $cat = $this->getCategoryForTimeEvent($day);

            // vordefinierte Minuten // Damit in Creates die gleichen Minuten verwendet werden
            $min = array("00", "15", "30", "45");
            $randomMinute1 = $min[rand(0, 3)];
            $randomMinute2 = $min[rand(0, 3)];

            // Normalerweise bei Events kein accepted
            $accepted = false;

            // Bei Illness und Vacation manchmal schon akzeptiert
            if (($cat == 3 || $cat == 4) && rand(0, 1) == 0) {
                $accepted = true;
            }

            // Create Time-Event
            CalendarEvent::create(array(
                'date' => $DBdate,
                'from' => $time[$i] . ':' . $randomMinute1,
                'to' => $time[$i + 1] . ':' . $randomMinute2,
                'accepted' => $accepted,
                'employee_id' => $emp->id,
                'category_id' => $cat,
            ));


            // Manchmal Workt Final Event
            if ($day <= $nextNextSunnday && $cat == 1 && (rand(0, 1) == 0 || rand(0, 2) == 0)) {

                // Create TimeEvent
                CalendarEvent::create(array(
                    'date' => $DBdate,
                    'from' => $time[$i] . ':' . $randomMinute1,
                    'to' => $time[$i + 1] . ':' . $randomMinute2,
                    'accepted' => $accepted,
                    'employee_id' => $emp->id,
                    'category_id' => 2,
                ));
            }


            $i += 2;

            if (!$bool) {
                break;
            }
        }
    }


    public function run()
    {
        $this->addRoles();
        $this->addCategorys();


        /* ---------------------- Company -------------------------- */

        $adminAddress1 = $this->addAddress('Alexanderplatz', '1', '10178', 'Berlin', 'Deutschland');
        $adminAddress2 = $this->addAddress('Sonnenstraße', '19', '80331', 'München', 'Deutschland');

        $this->addCompanies('Fashion Style GmbH', 'Daniel', 'Maier', $adminAddress1); // fuer login
        $this->addCompanies('IT-Support GmbH', 'Dieter', 'Menge', $adminAddress2);


        /* ---------------------- Retail Stores -------------------------- */

        $store1Address = $this->addAddress('Alexanderplatz', '3', '10178', 'Berlin', 'Deutschland');
        $store2Address = $this->addAddress('Königsstraße', '20-22', '70173', 'Stuttgart', 'Deutschland');
        $store3Address = $this->addAddress('Münsterplatz', '7', '78462', 'Konstanz', 'Deutschland');
        $store4Address = $this->addAddress('Breslauer Platz', '2B', '50668', 'Köln', 'Deutschland');
        $store5Address = $this->addAddress('Rosenstraße', '9', '80331', 'München', 'Deutschland');
        $store6Address = $this->addAddress('Schloßstraße', '2', '01067', 'Dresden', 'Deutschland');


        $this->addRetailStore($store1Address);
        $this->addRetailStore($store2Address);
        $this->addRetailStore($store3Address);
        $this->addRetailStore($store4Address);
        $this->addRetailStore($store5Address);
        $this->addRetailStore($store6Address);


        /* ---------------------- Employee -------------------------- */

        $this->addEmployee('Joachim', 'Buhl'); // fuer login
        $this->addEmployee('Simon', 'Maier');
        $this->addEmployee('Gerhart', 'Jung');
        $this->addEmployee('Jürgen', 'Friedrich');
        $this->addEmployee('Fabian', 'Gustav');
        $this->addEmployee('Olaf', 'Müller');
        $this->addEmployee('Maria', 'Wehrle');
        $this->addEmployee('Alena', 'Staubach');
        $this->addEmployee('Angelica', 'Biber');
        $this->addEmployee('Catharina', 'Altmeyer');
        $this->addEmployee('Kevin', 'Bayer');
        $this->addEmployee('Dario', 'Bergmann');
        $this->addEmployee('Jari', 'Dietrich');
        $this->addEmployee('Edith', 'Eckert');
        $this->addEmployee('Britta', 'Fink');
        $this->addEmployee('Ally', 'Fuchs');
        $this->addEmployee('Emily', 'Gericke');
        $this->addEmployee('Jerome', 'Goldschmidt');
        $this->addEmployee('Timm', 'Hellmich');
        $this->addEmployee('Patrick', 'Kapp');
        $this->addEmployee('Hilda', 'Kiesel');
        $this->addEmployee('Isabelle', 'Knaus');
        $this->addEmployee('Janine', 'Krammer');
        $this->addEmployee('Nicolas', 'Kuhlmann');
        $this->addEmployee('Michael', 'Kuhn');
        $this->addEmployee('Paul', 'Lehner');
        $this->addEmployee('Nicolas', 'Maucher');
        $this->addEmployee('Peter', 'Neubauer');
        $this->addEmployee('Steffen', 'Rahm');


        /* ----------------------- Event -------------------------- */

        $this->addCalendarEvents();
    }
}
