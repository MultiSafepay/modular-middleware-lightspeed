<?php


use App\Models\lightspeed;
use Illuminate\Database\Eloquent\Factories\Factory;

class lightspeedFactory extends Factory
{
    protected $model = lightspeed::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'language' => '',
            'shop_id' => '',
            'cluster_id' => '',
            'token' => '',
            'api_key' => '',
        ];
    }
}
