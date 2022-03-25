<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Admin
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmCaseta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmConEspecialidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmCorreoPersonal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmEsjefe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmInicial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmPrimerLogeo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereAdmVigencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereDepeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin wherePushId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Admin extends User
{
}
