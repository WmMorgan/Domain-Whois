<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iodev\Whois\Factory;


class WhoisController extends Controller
{
    private $whois;

    /**
     * WhoisController constructor.
     * @param $whois
     */
    public function __construct()
    {
        $this->whois = Factory::get()->createWhois();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "ok";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'domen' => 'required'
        ]);
        if ($validator->fails()) {
            $res = [
                'status' => false,
                'post' => $validator->errors()
            ];
            return response()->json($res)->setStatusCode(404);
        }
        try {
            $info = $this->whois->loadDomainInfo($request->domen);
            $ifavailable = $this->whois->isDomainAvailable($request->domen);
            if ($ifavailable == false) {
                $res = [
                    'status' => true,
                    'post' => ['domain_created' => date("Y-m-d", $info->creationDate),
                        'domain_expires' => date("Y-m-d", $info->expirationDate),
                        'domain_owner' => $info->owner]
                ];
                return response()->json($res)->setStatusCode(200);
            } else {
                throw new \Exception("The domen is available", 200);
            }
        } catch (\Exception $e) {
                $res = [
                    'status' => false,
                    'post' => $e->getMessage()
                ];
                return response()->json($res);
        }


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
        //
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
        //
    }
}
