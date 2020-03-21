<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\posts;
use App\comments;
use App\User;
use App\views;
use Cookie;
use Validator;
use Redirect;

class postsController extends Controller
{
    //Index Page
    public function index(){
        $allCat = \DB::table('categories')
                        ->select('*')
                        ->get()
                        ->toArray();

        $usernameCookie = $this->setMyCookie();


        $allData = $this->getPost(0);

        $response = response(view('index', ['allPosts' => $allData, 'allCat' => $allCat]));

        if ($usernameCookie != '') {

            $response = $response->cookie(cookie('userConfV2', $usernameCookie, 525600));
            
        }

        return $response;

    }




    //Show FullPost

    public function getFullPost($idPost, Request $request){

        //Add To Views Count
        views::create(['idPost' => $idPost,'idUser' => Session()->get('userConfV2')]);
        $allData = $this->getPost(0, ['posts.id', '=' ,$idPost]);
        $allComments = comments::where('idPost' ,'=' , $idPost)->orderBy('created_at', 'DESC')->get()->toArray();
        
        if ($request->ajax() && Session()->has('userConfV2')) {
            return view('miniViews.showFullPost', ['allData' => $allData, 'allComments' => $allComments]);
        } else {
            return ['allData' => $allData, 'allComments' => $allComments];
        }
    }

    //Most Viewed Posts
    public function mostView($skip = 0) {

        return $this->getPost($skip, [], ['countViews', 'DESC']);

    }


    //Search
    public function search($keyword, $skip = 0){

        if (Request()->ajax() && Session()->has('userConfV2')) {

            $validate = Validator::make(['keyword' => $keyword],

                                    [
                                        'keyword' => 'required|string'
                                    ], [

                                        'keyword.required' => 'هناك خطأ ما',
                                        'keyword.string' => 'هناك خطأ ما'
                                    ]

                                    )->validate();


            if (is_null($validate)) {
                $myKeyWord = explode(' ', $keyword);
                $keyw = '';
                foreach ($myKeyWord as $value) {
                    $keyw .= '%' . $value;
                    if (end($myKeyWord) == $value) {
                        $keyw .= '%';
                    }
                }

                $allData = $this->getPost($skip, ['posts.post', 'like', '%' . $keyw . '%']);
            
                if (!empty($allData)) {
                    return view('miniViews.getPost', ['allPosts' => $allData]);
                }
            }

        }

    }

    //Get Shared Post
    public function shared($id){
        $allCat = \DB::table('categories')
                        ->select('*')
                        ->get()
                        ->toArray();


        $fullPost = $this->getFullPost($id, Request());


        return view('shared', ['allData' => $fullPost['allData'], 'allComments' => $fullPost['allComments'] ,'allCat' => $allCat]);



    }

    //Get Post
    public function getPost($skip, $where = [], $orderBy = ['created_at', 'DESC']){

        if (Session()->has('userConfV2')) {

            $allData = posts::select('posts.*', 'categories.color', 'categories.catArab',
                                    \DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.idPost = posts.id) AS countLikes'),
                                    \DB::raw('(SELECT COUNT(id) FROM comments WHERE comments.idPost = posts.id) AS countComments'),
                                    \DB::raw('(SELECT COUNT(id) FROM shares WHERE shares.idPost = posts.id) AS countShares'),
                                    \DB::raw('(SELECT COUNT(id) FROM views WHERE views.idPost = posts.id) AS countViews'),
                                    \DB::raw('(SELECT 1 FROM likes WHERE likes.idPost = posts.id AND likes.idUser = ' . Session()->get('userConfV2') . ') AS productLiked')
                                    )
                            ->join('categories', 'categories.id', '=', 'posts.idCategory')
                            ->orderBy($orderBy[0], $orderBy[1]);
            if ($where != []) {
                $allDaata = $allData->where($where[0],$where[1] , $where[2]);
            }
            $allData = $allData->skip($skip)->take(18)->get()->toArray();
            $allData = $this->toArabicDate($allData);


            if (Request()->ajax()) {

                //Which mean's i want to get the full post on clicking on the post
                if ($where != []) {
                    return $allData;
                } else {

                    //which mean's i want to get more posts in the scroll
                    return view('miniViews.getPost', ['allPosts' => $allData]);
                }

            } else {
            
                return $allData;

            }

        }

    }


    protected function getPostByCat($idCat, $skip = 0){

        if (Request()->ajax() && Session()->has('userConfV2')) {

            $allData = $this->getPost($skip, ['categories.id','=' ,$idCat]);

            return view('miniViews.getPost', ['allPosts' => $allData]);

        }

    }


    public function addPost(Request $req){
        if ($req->ajax() && Session()->has('userConfV2')) {

            $validate = Validator::make($req->all(), [

                            'category' => 'required|numeric',
                            'thePost' => 'required|min:150'

                        ],
                        [

                            'category.required' => 'من فضلك اختر تصنيفا محددا',
                            'category.numeric' => 'من فضلك اختر تصنيفا محددا',
                            'thePost.required' => 'الاعتراف يجب ان يحتوي على 150 حرف على الأقل',
                            'thePost.min' => 'الاعتراف يجب ان يحتوي على 150 حرف على الأقل'


                        ])->validate();

            //This To Return The Errors message as JSON
            if (is_null($validate)) {
                posts::create(['idUser' => Session()->get('userConfV2'), 'idCategory' => $req->input('category'), 'post' => $req->input('thePost')]);
            }

        }
    }




    //Arabic Date
    protected function toArabicDate($array){

        $allData = $array;

        $arabicArray = [
                //'second' => 'ثانية' ,'seconds' => 'ثوان',
                //'minute' => 'دقيقة' ,'minutes' => 'دقائق' ,
                //'hours' => 'ساعة' ,'hour' => 'ساعات' ,
                'day' => 'يوم', 'days' => 'أيام' ,
                'week' => 'اسبوع','weeks' => 'اسابيع',
                'months' => 'اشهر' ,'month' => 'شهر',
                'year' =>'سنة', 'years' =>'سنوات'
                ];


        foreach($allData as $key => $data){
            //GET THE TIME EXPRESSION IN ARABIC WITH CARBON CLASS
            //EX : 3 Days ago , 2 Month Ago.....
            $created = new \Carbon\Carbon($data['created_at']);
            $now = \Carbon\Carbon::now();
            
            if($created->diff($now)->days <= 1) {
                $allData[$key]['created_at'] = 'اليوم';
            } else if ($created->diff($now)->days <= 2) {
                $allData[$key]['created_at'] = 'قبل يومين';
            } else if ($created->diffInMonths($now) == 1) {
                $allData[$key]['created_at'] = 'قبل شهر';
            }  else if ($created->diffInMonths($now) == 2) {
                $allData[$key]['created_at'] = 'قبل شهرين';
            }
            else {

                $arabicDate[$key] = explode(' ', $created->diffForHumans($now));
                $arabicDate[$key][1] = $arabicArray[$arabicDate[$key][1]];
                $arabicDate[$key][2] = 'قبل';
                $allData[$key]['created_at'] = $arabicDate[$key][2] . ' ' . $arabicDate[$key][0] . ' ' . $arabicDate[$key][1];
            }
        }

        return $allData;

    }

    public function setMyCookie(){

        if(!Cookie::has('userConfV2')){

            //Generate The Useranme
            $random = str_shuffle('apzoeirutyhgkfkdlsmqnwbxvc0192837465');
            $username = substr($random, 0, 3) . uniqid(substr($random, 0, -3));

            //Create A New User
            $idUser = User::insertGetId(['username' => $username]);


            //set a session for this user
            Session()->put('userConfV2', $idUser);

            return $idUser;

        } elseif(!Session()->has('userConfV2')) {
            
            $myUser = User::where('username', '=', Cookie::get('userConfV2'))->firstOrFail()->toArray();
            Session()->put('userConfV2', $myUser['id']);

            return '';

        }

    }
}
