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
        $this->call(UsersTableSeeder::class); /* Lecture 10 */
        $this->call(CitiesTableSeeder::class);   /* Lecture 10 */      
        $this->call(ObjectsTableSeeder::class); /* Lecture 10 */
        $this->call(AddressesTableSeeder::class); /* Lecture 10 */
        $this->call(NotificationsTableSeeder::class); /* Lecture 10 */
        $this->call(ArticlesTableSeeder::class); /* Lecture 10 */
        $this->call(CommentsTableSeeder::class); /* Lecture 10 */
        $this->call(LikeablesTableSeeder::class); /* Lecture 11 */
        $this->call(PhotosTableSeeder::class); /* Lecture 11 */
        $this->call(RoomsTableSeeder::class); /* Lecture 11 */
        $this->call(ReservationsTableSeeder::class); /* Lecture 11 */
        $this->call(RolesTableSeeder::class); /* Lecture 11 */
        $this->call(RoleUserTableSeeder::class); /* Lecture 11 */
    }
}
