<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Agent;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const USER_ROLE = [
                                'admin', // can access everything: gate => true
                                'agent', // can access everything under same agent: gate => (agent == agent)
                                'agent_user',  // can access everything under same user: gate => (user == user)
                                'hub_user'  // can do allowed task (permission controlled) 
                             ];



    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getAllowedRoles()
    {
        return self::USER_ROLE;
    }


    public function isAdmin()
    {
        return $this->agent_id == Agent::ADMIN_AGENT && $this->role == 'admin';
    }

    public function isAgent()
    {
        return $this->role == 'agent';
    }

    public function isAgentUser()
    {
        return $this->role == 'agent_user';
    }

    public function isHubAdmin()
    {
        return isset($this->hub_id) && $this->is_hub_admin;
    }

    public function isHubUser()
    {
        return isset($this->hub_id) && $this->role == 'hub_user';
    }


    //Panel Permission
    public function canAccessAdminPanel()
    {
        return in_array($this->role, ['admin']) && $this->agent_id == Agent::ADMIN_AGENT;
    }

    public function canAccessAgentPanel()
    {
        //all agent users can access
        //agent users must have users.agent_id, and it must not be admin-agent
        return isset($user->agent_id) && $this->agent_id != Agent::ADMIN_AGENT;
    }

    public function canAccessHubPanel()
    {
        return isset($user->hub_id);
    }


}
