<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Weather\Interfaces\FrontendRepositoryInterface;
use App\Weather\Gateways\FrontendGateway;
use App\Exceptions\WheaterException;
use App\Exceptions\NoSetDefaultCityException;

class FrontendController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FrontendRepositoryInterface $frontendRepository, FrontendGateway $frontendGateway){
        $this->frontendRepository = $frontendRepository;
        $this->frontendGateway = $frontendGateway;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        try {

            $weather = $this->frontendGateway->getWeaterDefaultCity();
            return view('frontend', ['weather' => $weather]);
        } 
        catch (WheaterException $ex) {
            return view('frontend')->with("error", $ex->getMessage());
        }
        catch (NoSetDefaultCityException $ex) {
            return view('frontend')->with("error", $ex->getMessage());
        }
    }

    public function ajaxGetCities(Request $request) {
        if ($request->ajax()) {
            $cities = $this->frontendRepository->getCities($request->get('search'));
            return response()->json($cities);
        }
    }

    public function ajaxSearchWheaterForCity(Request $request) {
        if ($request->ajax()) {
            $weather = $this->frontendGateway->getWeaterForCity($request->get('id'));
            return response()->json(['status' => 'ok', 'weather' => $weather]);
        }
    }

}
