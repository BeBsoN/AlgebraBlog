<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable; //dodao namespace za slug


class Post extends Model
{
    //trait, dostupan nam je samo zbog ovog gore name space-a koji smo ubacili
	
	use Sluggable;
	
	
    /**
     * The attributes that are mass assignable.
     * većinom se stavlja fillable, guarded se rjetko koristi. Punim podatke title, contet i user_id
     * @var array
     */
    protected $fillable = [
					'title',
					'content',
					'user_id'];
					
	/**
	*Save new post.
	+
	+@param array $date
	*@return int $id
	*Once we have made the attributes mass assignable, we can use the create method to insert a new record in the database. The create method returns the saved model instance:
	*return object Post
	*/
	
	public function savePost($post)
	{
		return $this->create($post); // create se nalazi u klasi Model koju extendamo
	}
	
	/**
	*Update post.
	+
	+@param array $date
	*@return int $id
	*@return void   nema potrebe išta vraćati
	*/
	
	public function updatePost($post)
	{
		return $this->update($post); // create se nalazi u klasi Model koju extendamo
	}
	
	

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() //pretvara slug u title, umjesto razmaka imamo -, zamjena za hrv riječi. SEO friendly
    {
        return [
            'slug' => [					//isto slug mora biti u bazi
                'source' => 'title'  //source mora biti stupac u bazi, mi imamo 'title'
            ]
        ];
    }
	
}

