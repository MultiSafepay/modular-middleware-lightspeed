<?php


use App\Models\Lightspeed;
use Illuminate\Database\Eloquent\Factories\Factory;

class LightspeedFactory extends Factory
{
    protected $model = Lightspeed::class;
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
