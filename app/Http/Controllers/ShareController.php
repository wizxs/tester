<?php namespace App\Http\Controllers;

use App\Group;
use App\Http\Group\GroupRepository;
use App\Http\Pack\PackRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\SearchRequest;
use App\Http\Share\ShareRepository;
use Illuminate\Http\Request;

class ShareController extends Controller {
    /**
     * @var ShareRepository
     */
    private $repository;
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @param ShareRepository $repository
     * @param GroupRepository $groupRepository
     */
    function __construct(ShareRepository $repository, GroupRepository $groupRepository)
    {

        $this->repository = $repository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $file
     * @param Request $request
     * @return Response
     */
	public function index($file, Request $request)
	{
        $title = "Groups to share to:";

        if($request->value)
        {
            $groups = $this->groupRepository->searchMyGroups($request->value, \Auth::user());
            $tagline = 'Results('.$groups->count().') for "'.$request->value.'"';
            return view('inspina.pack.myGroup', compact('groups', 'title', 'tagline', 'file'));
        }
        $tagline = 'All your groups:';
        $groups= \Auth::user()->follows()->paginate(9);
        return view('inspina.pack.myGroup', compact('title','tagline', 'groups', 'file'));
	}
    
    /**
     * Show the form for creating a new resource.
     *
     * @param $file
     * @param $group
     * @return Response
     */
	public function create($file, $group)
	{
        $this->repository->share($file, $group, \Auth::user());
        $this->flash('The file has been shared successfully to '.$group->name);
        return redirect()->back();
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param $group
     * @param $user
     * @return Response
     */
	public function shared($group, $user)
	{

        $title = $user->fullname(). ' Shared Files:';
		$documents = $group->sharedFiles()->where('user_id', $user->id)->latest()->paginate(9);
        $sharers = $group->sharers()->get();
        return view('inspina.pack.files', compact('documents', 'group', 'sharers', 'title', 'user'));
	}

    /**
     * Display the specified resource.
     *
     * @param $group
     * @internal param int $id
     * @return Response
     */
	public function show($group)
	{
        $title = 'Shared Files';
        $documents = $group->sharedFiles()->latest()->paginate(9);
        $sharers = $group->sharers()->get();
        return view('inspina.pack.shared', compact('sharers','group', 'title', 'documents'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param $file
     * @param $query
     * @internal param int $id
     * @return Response
     */
    public function getSearch($file, $query)
    {
        $title = 'Groups To Share to';
        $groups = $this->groupRepository->searchMyGroups($query, \Auth::user());
        $tagline = 'Results('.$groups->count().') for "'.$query.'"';
        return view('inspina.pack.myGroup', compact('groups', 'title', 'tagline', 'file'));
    }

    /**
     * * Funtion for searching through the group records.
     * @param SearchRequest $request
     * @param $file
     * @return \Illuminate\View\View
     */
    public function search(SearchRequest $request, $file)
    {

        return redirect('/share/' .$file->id.'/'.$request->value.'/search/');
    }

}
