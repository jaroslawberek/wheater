<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Weather\Interfaces\FrontendRepositoryInterface;
use App\Weather\Gateways\FrontendGateway;

class Cities extends Controller {

    public function __construct(FrontendRepositoryInterface $frontendRepository, FrontendGateway $frontendGateway) {
        $this->frontendRepository = $frontendRepository;
        $this->frontendGateway = $frontendGateway;
    }

    public function index() {
        $cities = $this->frontendRepository->getCities("");
        return view('cities', ['cities' => $cities]);
    }

    public function store(Request $request) {

        $errors = $this->frontendGateway->insertCity($request->all());

        if (count($errors) > 0)
            return response()->json(['errors' => $errors]);
        else
            return response()->json(['message' => "OK"]);
    }

    public function setDefault(Request $request) {

        $this->frontendGateway->setDefaultCity($request->id);
        if ($request->ajax()) {
            return response()->json(['message' => "OK"]);
        }
    }

    public function getOne(Request $request) {

        $city = $this->frontendRepository->getCityForId($request->id);
        if ($request->ajax()) {
            return response()->json(['city' => $city]);
        }
    }

    public function update(Request $request, $id) {
        $errors = $this->frontendGateway->updateCity($request->all());

        if (count($errors) > 0)
            return response()->json(['errors' => $errors]);
        else
            return response()->json(['message' => "OK"]);
    }

    public function destroy(Request $request, $id) {
        $this->frontendGateway->deleteCity($id);

        if ($request->ajax()) {
            return response()->json(['message' => "OK"]);
        } else {
            return redirect('citites');
        }
    }

}
