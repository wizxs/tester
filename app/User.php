<?php namespace App;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'firstName', 'lastName', 'telNumber', 'code', 'active', 'pin_notification'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function statuses()
    {
        return $this->hasMany('App\Post');
    }

    public function notices()
    {
        return $this->hasMany('App\Notice');
    }

    public function groups()
    {
        return $this->hasMany('App\Group');
    }

    public function userGroups()
    {
        return $this->groups()->get();
    }


    public function messages(){
        return $this->hasMany('App\Message');
    }
    
    public function follows()
    {
        return $this->belongsToMany('App\Group', 'follows', 'user_id', 'group_id')->withTimestamps();
    }

    public function followedGroups()
    {
        return $this->follows()->get();
    }

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function profileSource()
    {

        $profile = $this->hasOne('App\Profile')->first();
        if($profile != null)
            return $profile->source;

        return 'uploads/images/default/avatar.png';
    }

    public function attend()
    {
        return $this->belongsToMany('App\Event', 'attendances', 'user_id', 'event_id')->withTimestamps();
    }

    public function folders()
    {
        return $this->hasMany('App\UserFolder');
    }
    public function fullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function personalFiles()
    {
        return $this->hasMany('App\PersonalFile');
    }

    public function personalFolders()
    {
        return $this->hasMany('App\PersonalFolder');
    }

    public function publicFolders()
    {
        return $this->personalFolders()->where('permission', 1)->get();
    }
    public function shared()
    {
        return $this->belongsToMany('App\Group', 'sharers', 'user_id', 'group_id')->withTimestamps();
    }

    public function rootFolders()
    {
        return $this->personalFolders()->where('sub_directory', NULL)->get();
    }

    public function  administrates()
    {
        return $this->belongsToMany('App\Group', 'supervisors', 'user_id', 'group_id')->withTimestamps();
    }

    public static function scopeSearchFor($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%$value%");
    }

    public function isMailable()
    {
        if($this->pin_notification == 1)
        {
            return true;
        }

        return false;
    }

    public function isActive()
    {
        if($this->active == 1)
        {
            return true;
        }

        if($this->trialDays() <= 7)
        {
            return true;
        }

          return false;
    }

    Public function isTrial()
    {
        if($this->active == 0 && $this->trialDays() <=7)
        {
            return true;
        }

        return false;
    }
    public function trialDays()
    {
        $created = new Carbon($this->created_at);
        $now = Carbon::now();
        return $created->diff($now)->days;
    }

    public function forums()
    {
        return $this->hasMany('App\Forum');
    }

    public function forumPosts()
    {
        return $this->hasMany('App\ForumPost');
    }

    public function forumPostsOf($forum)
    {
        return $this->forumPosts()->where('forum_id', $forum->id)->get();
    }
}
