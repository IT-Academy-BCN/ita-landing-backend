<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email",
 *         example="johndoe@example.com"
 *     ),
 *     @OA\Property(
 *         property="dni",
 *         type="string",
 *         description="DNI",
 *         example="123456789"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Status",
 *         enum={"ACTIVE", "INACTIVE"},
 *         example="ACTIVE"
 *     ),
 *     @OA\Property(
 *         property="role",
 *         type="string",
 *         description="Role",
 *         enum={"ADMIN", "REGISTERED"},
 *         example="ADMIN"
 *     ),
 *     @OA\Property(
 *         property="email_verified_at",
 *         type="string",
 *         format="date-time",
 *         description="Email verification timestamp",
 *         example="2023-06-19T12:00:00+00:00"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Password",
 *         example="********"
 *     ),
 *     @OA\Property(
 *         property="remember_token",
 *         type="string",
 *         description="Remember token"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp",
 *         example="2023-06-19T12:00:00+00:00"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp",
 *         example="2023-06-19T13:30:00+00:00"
 *     )
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'dni',
        'password',
        'status',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
