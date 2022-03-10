<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::query();

        // Filter
        if ($request->has('search')) {
            $roles->where('slug', 'ilike', "%{$request->search}%")
                ->orWhere('name', 'ilike', "%{$request->search}%");
        }

        // Order
        if ($request->has('sort')) {
            $sortArray = json_decode($request->get('sort'), true);
            foreach ($sortArray as $column => $direction) {

                if (!$direction) {
                    continue;
                }

                $roles->orderBy($column, $direction);
            }
        }

        if ($request->get('list_only')) {
            return response()->json($roles->get());
        }        
        
        $result = $roles->paginate($request->get('per_page', 15));
        // $result = $roles->simplePaginate($request->get('per_page', 15));

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> ['required', 'min:3', 'max:200'],
            'slug'=> ['required', 'min:3', 'max:50', 'unique:roles,slug'],
            'description'=> ['nullable', 'min:3', 'max:200'],
            // 'permissions'=> [''],
        ]);

        $newRole = Role::create([
            'name'=> $request->get('name'),
            'slug'=> $request->get('slug'),
            'description'=> $request->get('description'),
        ]);

        abort_if(!$newRole, 403, "Failed to create Role!");

        return response()->json([
            'success'=> true,
            'message'=> "Territory has been created successfully!",
            'data'=> $newRole
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return response()->json([
            'success'=> true,
            'message'=> "Role has been loaded successfully!",
            'data'=> $role->load('features')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name'=> ['required', 'min:3', 'max:200'],
            'slug'=> ['required', 'min:3', 'max:50', 'unique:roles,slug,'.$role->id],
            'description'=> ['nullable', 'min:3', 'max:200'],
            // 'permissions'=> [''],
            'status'=> ['boolean']
        ]);

        $isUpdated = $role->update([
            'name'=> $request->get('name'),
            'slug'=> $request->get('slug'),
            'description'=> $request->get('description'),
            'status'=> $request->get('status')
        ]);

        abort_if(!$isUpdated, 403, "Failed to update Role!");

        return response()->json([
            'success'=> true,
            'message'=> "Territory has been updated successfully!",
            'data'=> Role::find($role->id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $deleted = $role->delete();

        abort_if(!$deleted, 403, "Failed to delete role.");

        return response()->json([
            'success'=> true,
            'message'=> "Role deleted successfully.",
            'data'=> null
        ]);
    }

    /**
     * Add role's feature ability
     * 
     * @param Request $request
     * @return mixed
     */
    public function addFeatureAbility(Request $request, Role $role)
    {
        DB::beginTransaction();
        try {

            $existing = $role->features()->where('feature_slug', $request->feature)->get();
            
            if (!$existing->count()) {
                $role->features()->attach($request->feature, [
                    'abilities'=> [
                        $request->ability=> $request->ability_value
                    ]
                ]);
            }

            if ($existing->count()) {
                $existingAbilities = $existing->first()->pivot->abilities;

                $role->features()->updateExistingPivot($request->feature, [
                    'abilities'=> array_merge($existingAbilities, [
                        $request->ability=> $request->ability_value
                    ])
                ]);
            }
            

            DB::commit();

            return response()->json([
                'success'=> true,
                'message'=> 'Role feature updated successfully!',
                'data'=> $role->load('features')
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Get collection of roles
     * 
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $rolesQuery = DB::table('roles')
            ->whereRaw("(roles.name ilike '%$request->term%' OR roles.slug ilike '%$request->term%')")
            ->limit(15)
            ->select(['com.id', 'com.name AS text']);

        return response()->json([
            'items'=> $rolesQuery->get()
        ]);        
    }

    /**
     * Get user's roles
     * 
     * @param Request $request
     * @return mixed
     */
    public function currentUserRoles(Request $request)
    {
        $userRoles = $request->user()->roles->load('features'); 
        // ->with('features')->select(['slug', 'name'])->get();

        return response()->json([
            'success'=> true,
            'message'=> 'User roles has been loaded successfully.',
            'data'=> $userRoles
        ]);
    }

}
