<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ShipmentPermissionScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
         $user = auth()->user();
        // CLI / jobs / unauthenticated
        if (!$user) {
            return;
        }

        //super user can do all
        if($user->isAdmin())
        {
            return;
        }

        
        
        //agent can view all under the agent_id
        if($user->isAgent())
        {
            return $builder->where('agent_id', '=', $user->agent_id);
        }

        //agent_user can access only self records
        if($user->isAgentUser())
        {
            return $builder->where('user_id', '=', $user->id);
        }


        
        //general user can view self records
        return $builder->where('user_id', '=', $user->id);  
    }
}
