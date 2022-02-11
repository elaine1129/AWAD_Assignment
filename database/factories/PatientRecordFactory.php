<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'patient_id' => $this->faker->randomElement(User::query()->whereRole('PATIENT')->pluck('id')->toArray()),
            'doctor_id' => $this->faker->randomElement(User::query()->whereRole('DOCTOR')->pluck('id')->toArray()),
            'symptoms' => implode(', ', $this->faker->randomElements(self::$common_symptoms, rand(1,5))),
            'diagnosis' => $this->faker->randomElement(['negative', 'positive']),
            'prescription' => implode(', ', $this->faker->randomElements(self::$medicine,rand(2,5))),
        ];
    }

    private static $common_symptoms = [
        'fever',
        'cough',
        'tiredness',
        'loss of taste or smell',
        'sore throat',
        'headache',
        'aches and pains',
        'diarrhoea',
        'a rash on skin, or discolouration of fingers or toes',
        'red or irritated eyes',
        'Serious symptoms:',
        'difficulty breathing or shortness of breath',
        'loss of speech or mobility, or confusion',
        'chest pain',
    ];
    static private $medicine = [
        'Synthroid (levothyroxine)',
        'Crestor (rosuvastatin)',
        'Ventolin HFA (albuterol)',
        'Nexium (esomeprazole)',
        'Advair Diskus (fluticasone)',
        'Lantus Solostar (insulin glargine)',
        'Vyvanse (lisdexamfetamine)',
        'Lyrica (pregabalin)',
        'Spiriva Handihaler (tiotropium',
        'Januvia (sitagliptin',
    ];
}
