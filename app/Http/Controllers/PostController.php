<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


// da se dođe do modela, Post model je package
use App\Models\Post;

use Sentinel;  //uključisno sentinel

Use Exception; // i exception za try catch blok


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//dohvat svih postova, Post extenda Model, au modelu je metoda all
		
		//controler je zaposio model, model vraća podatke, controler vraća u view
		$posts = Post::orderBy('created_at', 'DESC')->paginate(10); //paginate je 10 postova po stranici, orderbay također metoda u Modelu
		//U index metodi napraviti logiku da user ne vidi postove od Admina
		return view('centaur.posts.index',
		[
			'posts' => $posts  //ključ je naziv varijable, kada se šalje iz kontrolera na view
		]);
		
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('centaur.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Sentinel::getUser()->id; //id je property, metoda je getUser zato i ima ()
		
		$results = $this->validate($request, 
							[
							 'title' => 'required|max:191',  //191 jer smo stavili utf4 za emoticone, utf8 ima po def 255
							 'content' => 'required'
							]);
		$data= array(
					 'title' 	=> $request->get('title'),      //ključevi moraju biti nazivi stupaca u bazi, u () kroz metodu get šaljemo ime polja u obrascu
					 'content'  => $request->get('content'),
					 'user_id'	=> $user_id					//ovo smo već izvukli gore, get je metoda iz Request klase koju smo gore odmah instacirali
					);
		$post = new Post();
		
		try{
			
			$post->savePost($data);
			
		} catch(Exception $e){
			
			session()->flash('danger', $e->getMessage());
			return redirect()->back();
			
		}

			session()->flash('success', 'Uspješno ste dodali novi post');
			return redirect()->route('posts.index');
		
		//dd($user_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);// dohvat post-a, ako je krivi id : poruka
		
		//$post = Post::find($id);  --za ovu pizdariju moram pisati logiku, gore imamo gotovu metodu
		//abort(404);
		
		return view('centaur.posts.edit',
		[
			'post' => $post  //ključ je naziv varijable, kada se šalje iz kontrolera na view
		]);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$results = $this->validate($request, //prvo validirati podatke da se ne raddi upit na bazu bzvz
							[
							 'title' => 'required|max:191',  
							 'content' => 'required'
							]);
		$data= array(
					 'title' 	=> $request->get('title'),     
					 'content'  => $request->get('content'),
					);
					
        $post = Post::findOrFail($id); 
		
		try{
			
			$post->updatePost($data);
			
		} catch(Exception $e){
			
			session()->flash('danger', $e->getMessage());
			return redirect()->back();
			
		}

			session()->flash('success', 'Uspješno ste ažurirali <b>'.$post->title.'</b> post');
			return redirect()->route('posts.index');
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id); //ova metoda javlja: page cannot be found, find metoda samo nalazi post
		
		$post->delete();
		session()->flash('success', 'Uspješno ste izbrisali novi '.$post->title.' post');
		return redirect()->back();
		}
}
