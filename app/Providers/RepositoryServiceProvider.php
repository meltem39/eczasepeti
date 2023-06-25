<?php

namespace App\Providers;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineSubCategory;
use App\Models\NonMedicalCategory;
use App\Models\NonMedicalSubCategory;
use App\Models\NonMedicine;
use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\PharmacyList;
use App\Models\Prescriptions;
use App\Models\Shopping;
use App\Models\User;

use App\Repositories\Pharmacy\MedicineCategoryRepositories\MedicineCategoryRepository;
use App\Repositories\Pharmacy\MedicineCategoryRepositories\MedicineCategoryRepositoryInterface;
use App\Repositories\Pharmacy\MedicineRepositories\MedicineRepository;
use App\Repositories\Pharmacy\MedicineRepositories\MedicineRepositoryInterface;
use App\Repositories\Pharmacy\NonMedicineRepositories\NonMedicineRepository;
use App\Repositories\Pharmacy\NonMedicineRepositories\NonMedicineRepositoryInterface;
use App\Repositories\Pharmacy\PharmacyRepositories\PharmacyRepository;
use App\Repositories\Pharmacy\PharmacyRepositories\PharmacyRepositoryInterface;
use App\Repositories\User\ListRepositories\ListRepository;
use App\Repositories\User\ListRepositories\ListRepositoryInterface;
use App\Repositories\User\PrescriptionRepositories\PrescriptionRepository;
use App\Repositories\User\PrescriptionRepositories\PrescriptionRepositoryInterface;
use App\Repositories\User\ShoppingRepositories\ShoppingRepository;
use App\Repositories\User\ShoppingRepositories\ShoppingRepositoryInterface;
use App\Repositories\User\UserRepositories\UserRepository;
use App\Repositories\User\UserRepositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MedicineRepositoryInterface::class, MedicineRepository::Class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->bind(UserRepositoryInterface::class, function($app) { return new UserRepository(new User); });
        $this->app->bind(PharmacyRepositoryInterface::class, function ($app) { return new PharmacyRepository(new Pharmacy); });
        $this->app->bind(MedicineRepositoryInterface::class, function ($app) { return new MedicineRepository(new Medicine); });
        $this->app->bind(PrescriptionRepositoryInterface::class, function ($app) { return new PrescriptionRepository(new Prescriptions); });
        $this->app->bind(ListRepositoryInterface::class, function ($app) {
            return new ListRepository(
                new PharmacyList,
                new Prescriptions,
                new Medicine,
                new MedicineCategory,
                new MedicineSubCategory,
                new NonMedicine,
                new NonMedicalCategory,
                new NonMedicalSubCategory
            );
        });
        $this->app->bind(NonMedicineRepositoryInterface::class, function ($app) { return new NonMedicineRepository(new NonMedicine); });
        $this->app->bind(ShoppingRepositoryInterface::class, function ($app) { return new ShoppingRepository(new Shopping, new Order, new User, new Pharmacy); });
    }
}
