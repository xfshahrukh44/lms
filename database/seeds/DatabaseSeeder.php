<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //roles
        DB::table('roles')->insert([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        
        DB::table('roles')->insert([
            'name' => 'teacher',
            'guard_name' => 'web',
        ]);

        DB::table('roles')->insert([
            'name' => 'student',
            'guard_name' => 'web',
        ]);

        DB::table('roles')->insert([
            'name' => 'guest',
            'guard_name' => 'web',
        ]);

        //users
        DB::table('users')->insert([ 
            'role_id' => '1',
            'name' => 'shahrukh', 
            'email' => 'a@a.com', 
            'password' => bcrypt('pajgptam2'), 
        ]);
        
        DB::table('users')->insert([ 
            'role_id' => '1',
            'name' => 'Admin', 
            'email' => 'admin@admin.com', 
            'password' => bcrypt('12345678'), 
        ]);

        for($i = 1; $i <= 10; $i++)
        {
            DB::table('users')->insert([ 
                'role_id' => '2',
                'name' => 'Teacher'.' '.$i, 
                'email' => 't'.$i.'@teacher.com', 
                'password' => bcrypt('12345678'), 
            ]);
        }

        for($i = 1; $i <= 80; $i++)
        {
            DB::table('users')->insert([ 
                'role_id' => '3',
                'name' => 'Student'.' '.$i, 
                'email' => 's'.$i.'@student.com', 
                'password' => bcrypt('12345678'), 
            ]);
        }

        //model has roles
        DB::table('model_has_roles')->insert([ 
            'role_id' => '1',
            'model_id' => '1',
            'model_type' => 'App\User',
        ]);

        DB::table('model_has_roles')->insert([ 
            'role_id' => '1',
            'model_id' => '2', 
            'model_type' => 'App\User',
        ]);

        for($i = 3; $i <= 12; $i++)
        {
            DB::table('model_has_roles')->insert([ 
                'role_id' => '2',
                'model_id' => $i, 
                'model_type' => 'App\User',
            ]);
        }

        for($i = 13; $i <= 92; $i++)
        {
            DB::table('model_has_roles')->insert([ 
                'role_id' => '3',
                'model_id' => $i, 
                'model_type' => 'App\User',
            ]);
        }

        //program
        DB::table('programs')->insert([ 
            'title' => 'Sindh board',
        ]);

        //school
        DB::table('schools')->insert([ 
            'title' => 'SM Public Acaemy',
            'location' => 'Nazimabad # 3', 
            'program_id' => '1', 
        ]);

        //classroom
        for($i = 1; $i <= 10; $i++)
        {
            DB::table('classrooms')->insert([ 
                'title' => $i,
                'school_id' => '1', 
            ]);
        }
        
        //section
        $section = ['A', 'B', 'C', 'D'];
        for($i = 1; $i <= 10; $i++)
        {
            for($j = 0; $j <= 3; $j++)
            {
                DB::table('sections')->insert([ 
                    'title' => $section[$j],
                    'classroom_id' => $i, 
                ]);
            }
        }

        //course
        $course = ['Urdu', 'English', 'Maths', 'Science', 'Geography', 'Social Studies', 'Physics', 'Chemistry', 'Computer', 'Sindhi'];
        for($i = 1; $i <= 10; $i++)
        {
            for($j = 0; $j <= 9; $j++)
            {
                DB::table('courses')->insert([ 
                    'title' => $course[$j],
                    'classroom_id' => $i, 
                ]);
            }
        }
        
        
        //student
        for($i = 1, $j =13; $i <= 40, $j <= 92; $i++, $j++)
        {
            DB::table('students')->insert([ 
                'name' => 'Student '.$i,
                'contact' => '666', 
                'address' => 'asd', 
                'section_id' => $i,
                'user_id' => $j,
            ]);
        }

        //teacher
        for($i = 3, $j = 1; $i <= 12, $j <= 10; $i++, $j++)
        {
            DB::table('teachers')->insert([ 
                'name' => 'Teacher '.$j,
                'contact' => '666', 
                'address' => 'asd', 
                'user_id' => $i, 
            ]);
        }
        

        //session
        // for($i = 1; $i <= 40; $i++)
        // {
        //     for($j = 1; $j <= 10; $j++)
        //     {
        //         DB::table('sessions')->insert([ 
        //             'section_id' => $i,
        //             'course_id' => $j, 
        //             'teacher_id' => $j,
        //             'meeting_url' => 'https://meet.google.com/duo-mbgq-mxy' 
        //         ]);
        //     }
        // }
        for($i = 1; $i <= 4; $i++)
        {
            for($j = 1; $j <= 4; $j++)
            {
                for($k = 1; $k <= 4; $k++)
                {
                    DB::table('sessions')->insert([ 
                        'section_id' => $i,
                        'course_id' => $j, 
                        'teacher_id' => $k,
                        'meeting_url' => 'https://meet.google.com/duo-mbgq-mxy' 
                    ]);
                }
            }
          
        }
        
    }
}
