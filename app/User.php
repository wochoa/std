<?php

namespace App;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;

/**
 * App\User
 *
 * @property int $id
 * @property string|null $adm_name
 * @property string|null $adm_lastname
 * @property string|null $adm_inicial
 * @property string|null $adm_email
 * @property string|null $adm_password
 * @property int|null $adm_estado
 * @property string|null $adm_cargo
 * @property string|null $adm_correo
 * @property int|null $depe_id
 * @property string|null $adm_vigencia
 * @property string|null $adm_observacion
 * @property string|null $adm_tipo
 * @property float|null $adm_caseta
 * @property float|null $adm_esjefe
 * @property string|null $adm_correo_personal
 * @property string|null $adm_telefono
 * @property string|null $adm_direccion
 * @property string|null $adm_dni
 * @property string|null $adm_con_especialidad
 * @property string|null $push_id
 * @property int|null $adm_primer_logeo
 * @property string|null $remember_token
 * @property string|null $api_token
 * @property string|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Caffeinated\Shinobi\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Caffeinated\Shinobi\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmCaseta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmConEspecialidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmCorreoPersonal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmEsjefe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmInicial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmPrimerLogeo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmVigencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDepeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePushId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasRolesAndPermissions;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['adm_name', 'adm_email', 'adm_password', 'adm_password2',];
    protected $table = 'admin';
    protected $primaryKey = 'id';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['adm_password','adm_password2', 'adm_password3', 'api_token', 'push_id', 'remember_token',];

    public function getAuthPassword()
    {
        return $this->adm_password;
    }
    public function getForUpdate()
    {

        $roles=RoleUser::select('role_user.id', 'role_id','name')
                                    ->join('roles','roles.id','=','role_user.role_id')
                                    ->where('user_id','=',$this->id)
                                    ->get();

        return json_encode((Object)[
            'id'                        =>$this->id,
            'adm_name'                  =>$this->adm_name,
            'adm_lastname'              =>$this->adm_lastname,
            'adm_inicial'               =>$this->adm_inicial,
            'adm_email'                 =>$this->adm_email,
            'adm_estado'                =>$this->adm_estado,
            'adm_cargo'                 =>$this->adm_cargo,
            'adm_correo'                =>$this->adm_correo,
            'adm_telefono'              =>$this->adm_telefono,
            'adm_dni'                   =>$this->adm_dni,
            'adm_direccion'             =>$this->adm_direccion,
            'adm_con_especialidad'      =>$this->adm_con_especialidad,
            'depe_id'                   =>$this->depe_id,
            'adm_vigencia'              =>$this->adm_vigencia,
            'adm_observacion'           =>$this->adm_observacion,
            'adm_primer_logeo'          =>$this->adm_primer_logeo,
            'adm_password'              =>null,
            'roles'                     =>$roles,
            ]);
    }

    public function getNombre()
    {
        return $this->adm_name.' '.$this->adm_lastname;
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'depe_id','iddependencia')->select('iddependencia','depe_nombre','depe_depende');
    }

    protected static function filter($request, $query)
    {
        //Aqui definimos los filtros segun sea el caso
        if ($request->dependencia) {
            $query->where(['td1.depe_depende' =>  $request->dependencia, 'adm_estado' => 1]);
        }
        if ($request->table_id) {
            $query->where(['table_id' => $request->table_id]);
        }
    }
    protected static function joinWhere($request, $query)
    {
        //Aqui definimos los filtros segun sea el caso
        if ($request->dependencia) {
            $query->join('tram_dependencia as td1', 'depe_id', '=', 'td1.iddependencia');
        }
        if ($request->table_id) {
            $query->where(['table_id' => $request->table_id]);
        }
        return $query;
    }
}
