<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

// Function to generate a unique snumber
function generateUniqueSnumber($type)
{
    do {
        $snumber = ($type === 'teacher')
            ? 'S1' . fake()->regexify('[0-9]{3}')  // Teacher: S1XXX
            : 'S0' . fake()->regexify('[0-9]{3}'); // Student: S0XXX
    } while (User::where('snumber', $snumber)->exists());

    return $snumber;
}
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['teacher', 'student']);
        $snumber = generateUniqueSnumber($type);

        return [
            'name' => fake()->name(),
            'snumber' => $snumber,
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'type' => $type,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
