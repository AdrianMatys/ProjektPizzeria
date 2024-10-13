echo "Installing php packages"
composer install
echo "Migrating database"
php artisan migrate
echo "Downloading npm packages"
npm install
npm run dev