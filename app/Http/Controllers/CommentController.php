<?php
//u layoutu treba link comments, treba izlistati sve komentare, u kontroleru treba index metoda, ako je admin izlistati sve podatek, a ako sam običan korisnik vidim komentare samo od svojih postova, treba složiti approve/deny za admina,
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Sentinel;

use App\Models\Comment;

use Exception;

class CommentController extends Controller
{

    //sentinel auth provjeri da li je korisnik prijavljen u sustav, ako nije baca ga na redirect na login

    public function __construct()
    {
      $this->middleware('sentinel.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //$user_id = Sentinel::getUser()->id;
      if(Sentinel::inRole('administrator')){

        $comments = Comment::orderBy('created_at', 'DESC')->paginate(10);
        return view('centaur.comments.index',
        [
          'comments' => $comments  //ključ je naziv varijable, kada se šalje iz kontrolera na view
        ]);
      }
       else {
        //$posts = Post::where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(10);

          session()->flash('error', 'You don\'t have permissions to do that !!!');
          return redirect()->back();
        }
      }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  /*  public function create()
    {
        //
    }*/

    public function create()
    {

          try{
        $comment = Comment::where('status', 2)
                ->update(['status' => 1 ]);

      		} catch(Exception $e){

      			session()->flash('error', $e->getMessage());
      			return redirect()->back();

      		}

      			session()->flash('success', 'Uspješno su odobreni svi komentari na čekanju');
      			return redirect()->route('comments.index');
        }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $result = $this->validate($request,[
             'comment' => 'required'
           ]);

   $user_id = Sentinel::getUser()->id;
   if($user_id !== 1)
   {
   $data = array(
     'content' => $request->get('comment'),
     'post_id' => $request->get('post_id'),
     'user_id' => $user_id,
     'status'  => 2
   );
 }else {
   $data = array(
     'content' => $request->get('comment'),
     'post_id' => $request->get('post_id'),
     'user_id' => $user_id,
     'status'  => 1
   );
 }


   $comment = new Comment();

   try{
     $comment->saveComment($data);
   } catch(Exception $e){
     session()->flash('error', $e->getMessage());
     return redirect()->back();
   }

   session()->flash('success', 'Uspješno ste dodali novi komentar!');
   return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $comment = Comment::findOrFail($id);// dohvat post-a, ako je krivi id : poruka

      if(Sentinel::inRole('administrator') && $comment->status != 0){
        $comment->update(['status' => 0 ]);

  } else {
                  session()->flash('error', 'Komentar je već odbijen');
                  return redirect()->back();

        }
        session()->flash('success', 'Uspješno ste zabranili komentar');
        return redirect()->route('comments.index');


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $comment = Comment::findOrFail($id);// dohvat post-a, ako je krivi id : poruka

      if(Sentinel::inRole('administrator') && $comment->status != 1){
        $comment->update(['status' => 1 ]);

  } else {
                  session()->flash('error', 'Komentar je već odobren');
                  return redirect()->back();

        }
        session()->flash('success', 'Uspješno ste odobrili komentar');
        return redirect()->route('comments.index');


    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
      //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $comment = Comment::findOrFail($id); //ova metoda javlja: page cannot be found, find metoda samo nalazi post

  $comment->delete();
  session()->flash('success', 'Uspješno ste izbrisali  '.$comment->user->email.' komentar u '.$comment->post->title.' postu');
  return redirect()->back();
    }
}
