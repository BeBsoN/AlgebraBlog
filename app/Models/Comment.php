<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
					'content',
					'user_id',
                                        'post_id',
                                        'status'];
public function saveComment($comment)
	{
		return $this->create($comment); // create se nalazi u klasi Model koju extendamo
	}

/**
	*Update comment.
	+
	+@param array $date
	*@return int $id
	*@return void   nema potrebe išta vraćati
	*/
	
	public function updateComment($comment)
	{
		return $this->update($coment); // create se nalazi u klasi Model koju extendamo
		
	}
    /**
     * Get the comment  user. 1 komentar ima samo 1 user-a/authora
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * Get the comment post. 1 komentar pripada samo jednom user-u/authoru
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
    
}
