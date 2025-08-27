<?php

namespace Database\Factories;

use App\Models\LoanRequest;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoanRequest>
 */
class LoanRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\LoanRequest>
     */
    protected $model = LoanRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startAt = fake()->dateTimeBetween('now', '+1 month');
        $endAt = fake()->dateTimeBetween($startAt, $startAt->format('Y-m-d H:i:s') . ' +1 week');

        return [
            'request_number' => LoanRequest::generateRequestNumber(),
            'user_id' => User::factory(),
            'equipment_id' => Equipment::factory(),
            'supervisor_id' => User::factory(),
            'start_at' => $startAt,
            'end_at' => $endAt,
            'purpose' => fake()->sentence(10),
            'jsa_document_path' => '/uploads/jsa/' . fake()->uuid() . '.pdf',
            'status' => fake()->randomElement([
                LoanRequest::STATUS_PENDING,
                LoanRequest::STATUS_APPROVED,
                LoanRequest::STATUS_CHECKED_OUT,
                LoanRequest::STATUS_RETURNED,
                LoanRequest::STATUS_NEEDS_REPAIR,
            ]),
        ];
    }

    /**
     * Indicate that the loan request is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => LoanRequest::STATUS_PENDING,
            'approved_at' => null,
            'approved_by' => null,
        ]);
    }

    /**
     * Indicate that the loan request is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => LoanRequest::STATUS_APPROVED,
            'approved_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'approved_by' => User::factory(),
        ]);
    }

    /**
     * Indicate that the loan request is checked out.
     */
    public function checkedOut(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => LoanRequest::STATUS_CHECKED_OUT,
            'approved_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'approved_by' => User::factory(),
            'checked_out_at' => fake()->dateTimeBetween('-3 days', 'now'),
            'checked_out_by' => User::factory(),
        ]);
    }

    /**
     * Indicate that the loan request is overdue.
     */
    public function overdue(): static
    {
        $startAt = fake()->dateTimeBetween('-1 month', '-1 week');
        $endAt = fake()->dateTimeBetween($startAt, '-1 day');

        return $this->state(fn (array $attributes) => [
            'status' => LoanRequest::STATUS_OVERDUE,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'approved_at' => fake()->dateTimeBetween('-1 month', '-1 week'),
            'approved_by' => User::factory(),
            'checked_out_at' => fake()->dateTimeBetween('-1 month', '-1 week'),
            'checked_out_by' => User::factory(),
        ]);
    }

    /**
     * Indicate that the loan request needs repair.
     */
    public function needsRepair(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => LoanRequest::STATUS_NEEDS_REPAIR,
            'repair_notes' => 'JSA document incomplete. Please revise and resubmit.',
        ]);
    }
}