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
            'email' => 'admin@gmail.com', 
            'password' => bcrypt('12345678'), 
        ]);

        DB::table('users')->insert([ 
            'role_id' => '2',
            'name' => 'Teacher', 
            'email' => 't1@teacher.com', 
            'password' => bcrypt('pajgptam2'), 
        ]);

        DB::table('users')->insert([ 
            'role_id' => '2',
            'name' => 'Teacher 1', 
            'email' => 'teacher@gmail.com', 
            'password' => bcrypt('12345678'), 
        ]);

        DB::table('users')->insert([ 
            'role_id' => '3',
            'name' => 'Student 1', 
            'email' => 's1@student.com', 
            'password' => bcrypt('pajgptam2'), 
        ]);

        DB::table('users')->insert([ 
            'role_id' => '1',
            'name' => 'Student', 
            'email' => 'student@gmail.com', 
            'password' => bcrypt('12345678'), 
        ]);

        //model has roles
        DB::table('model_has_roles')->insert([ 
            'role_id' => '1',
            'model_id' => '1',
            'model_type' => 'App\User',
        ]);

        DB::table('model_has_roles')->insert([ 
            'role_id' => '2',
            'model_id' => '2', 
            'model_type' => 'App\User',
        ]);

        DB::table('model_has_roles')->insert([ 
            'role_id' => '3',
            'model_id' => '3',
            'model_type' => 'App\User',
        ]);


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
        DB::table('classrooms')->insert([ 
            'title' => '1',
            'school_id' => '1', 
        ]);

        //section
        DB::table('sections')->insert([ 
            'title' => 'A',
            'classroom_id' => '1', 
        ]);

        DB::table('sections')->insert([ 
            'title' => 'B',
            'classroom_id' => '1', 
        ]);

        //course
        DB::table('courses')->insert([ 
            'title' => 'Urdu',
            'classroom_id' => '1', 
        ]);
        
        //student
        DB::table('students')->insert([ 
            'name' => 'Student 1',
            'contact' => '666', 
            'address' => 'asd', 
            'section_id' => '1',
            'user_id' => '3', 
        ]);

        //teacher
        DB::table('teachers')->insert([ 
            'name' => 'Teacher 1',
            'contact' => '666', 
            'address' => 'asd', 
            'user_id' => '2', 
        ]);

        //session
        DB::table('sessions')->insert([ 
            'section_id' => '1',
            'course_id' => '1', 
            'teacher_id' => '1',
            'meeting_url' => 'https://meet.google.com/duo-mbgq-mxy' 
        ]);
    }
}
