<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Company;
use App\Position;
use App\Helpful;
use App\Review;


class ReviewJobController extends Controller
{

    public function helpful(Request $request){
        $userId = $request->userId;
        $reviewId = $request->reviewId;

        $isHelpful = Helpful::where('user_id', $userId)
            ->where('review_id', $reviewId)
            ->first();

        if($isHelpful == null){
            $h = new Helpful;
            $h->user_id = $userId;
            $h->review_id = $reviewId;
            $h->save();
        }
        else{
            Helpful::destroy($isHelpful->id);
        }

        $newCount = DB::select("SELECT count(*) as Count FROM reviews a join helpfuls b on a.id = b.review_id WHERE a.id = $reviewId")[0]->Count;

        return response()->json([
            'newCount' => $newCount,
        ]);
    }

    public function getReviewsPaging(){
        $select = [
            'companies.id as CompanyId',
            'companies.name as CompanyName',
            'positions.name as PositionName',
            'reviews.positive as ReviewPositive',
            'reviews.star as ReviewRating',
            'reviews.id as ReviewId'
        ];

        $result = DB::table('reviews')
            ->join('positions', 'positions.id', '=', 'reviews.position_id')
            ->join('companies', 'companies.id', '=', 'reviews.company_id')
            ->select($select)
            ->orderByRaw('reviews.created_at desc')
            ->paginate(20);

        return response()->json($result);
    }

    public function submitReview(Request $request){
        $companyExists = $request->companyExists;

        $rule = [
            'negara' => 'required',
            'perusahaan' => 'required',
            'kota' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
            'gaji' => 'required|digits_between:1,999999',
            'periode' => 'required',
            'lamabekerja' => 'required',
            'kelebihan' => 'required',
            'kekurangan' => 'required',
            'gaji_tunjangan' => 'numeric|min:1',
            'jenjang_karir' => 'numeric|min:1',
            'work_life_balance' => 'numeric|min:1',
            'nilai_budaya' => 'numeric|min:1',
            'manajemen_senior' => 'numeric|min:1',
        ];

        $errorMessage = [
            'negara.required' => 'wajib diisi',
            'perusahaan.required' => 'wajib diisi',
            'kota.required' => 'wajib diisi',
            'jabatan.required' => 'wajib diisi',
            'status.required' => 'wajib diisi',
            'gaji.required' => 'wajib diisi',
            'gaji.digits_between' => 'harus angka',
            'periode.required' => 'wajib diisi',
            'lamabekerja.required' => 'wajib diisi',
            'kelebihan.required' => 'wajib diisi',
            'kekurangan.required' => 'wajib diisi',
            'gaji_tunjangan.min' => 'wajib diisi',
            'jenjang_karir.min' => 'wajib diisi',
            'work_life_balance.min' => 'wajib diisi1',
            'nilai_budaya.min' => 'wajib diisi',
            'manajemen_senior.min' => 'wajib diisi',
        ];

        if($companyExists == 'false'){
            $rule['web'] = 'required';
            $rule['industri'] = 'required';
            $errorMessage['web.required'] = 'wajib diisi';
            $errorMessage['industri.required'] = 'wajib diisi';
        }

        $validator = Validator::make($request->all(), $rule, $errorMessage);
        if($validator->fails()){
            return response()->json([
                'type' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        // sukses
        // kalo jabatan gak ada, insert
        $jabatan = $request->jabatan;
        if(Position::where('name', $jabatan)->get()->count() == 0){
            $newPosition = new Position;
            $newPosition->name = $jabatan;
            $newPosition->save();
        }
        $jabatan = Position::where('name', $jabatan)->first()->id;

        // insert company kalo gak ada
        $perusahaan = $request->perusahaan;
        if($companyExists == 'false'){
            $newCompany = new Company;
            $newCompany->name = $request->perusahaan;
            $newCompany->company_category_id = $request->industri;
            $newCompany->city_id = $request->kota;
            $newCompany->website = $request->web;
            $newCompany->save();
            $perusahaan = $newCompany->id;
        }

        $newReview = new Review;
        $newReview->company_id = $perusahaan;
        $newReview->positive = $request->kelebihan;
        $newReview->negative = $request->kekurangan;
        $newReview->gaji_tunjangan = $request->gaji_tunjangan;
        $newReview->jenjang_karir = $request->jenjang_karir;
        $newReview->work_life_balance = $request->work_life_balance;
        $newReview->nilai_budaya = $request->nilai_budaya;
        $newReview->manajemen_senior = $request->manajemen_senior;
        $newReview->star = ($request->gaji_tunjangan + $request->jenjang_karir + $request->work_life_balance + $request->nilai_budaya + $request->manajemen_senior)/5;

        $newReview->position_id = $jabatan;
        $newReview->city_id = $request->kota;
        $newReview->lama_bekerja = $request->lamabekerja;
        $newReview->status_karyawan = $request->status;
        $newReview->gaji = $request->gaji;
        $newReview->periode = $request->periode;
        $newReview->save();

        $users = DB::select("select user_id from follows where company_id = $perusahaan");
        return response()->json([
            'type' => 'success',
            'message' => 'terima kasih',
            'users' => $users,
            'review_id' => $newReview->id,
        ]);
    }

    public function reviewsFromCompany(Request $request){
        $company_id = $request->company_id;
        $company = Company::find($company_id);
        $reviews = $company->reviews;
        $item_id = $request->item_id;
        $user_id = $request->user_id;

        $finalResult = [];
        foreach ($reviews as $review) {
            $reviewid = $review->id;
            $helpfulCount = DB::select("SELECT count(*) as Count FROM reviews a join helpfuls b on a.id = b.review_id WHERE a.id = $reviewid")[0]->Count;
            $helpfulAlready = Helpful::where('user_id', $user_id)->where('review_id', $reviewid)->first() != null;

            $temp = [
                'ReviewId' => $review->id,
                'ReviewPositive' => $review->positive,
                'ReviewNegative' => $review->negative,
                'ReviewCity' => $review->city->name,
                'ReviewTime' => $review->created_at,
                'PositionName' => $review->position->name,
                'ReviewHelpful' => $helpfulCount,
                'ReviewHelpfulAlready' => $helpfulAlready,
                'ReviewRating' => $review->star,
                'ReviewGajiTunjangan' => $review->gaji_tunjangan,
                'ReviewJenjangKarir' => $review->jenjang_karir,
                'ReviewWorkLifeBalance' => $review->work_life_balance,
                'ReviewNilaiBudaya' => $review->nilai_budaya,
                'ReviewManajemenSenior' => $review->manajemen_senior,
            ];

            if($reviewid == $item_id) $top = $temp;
            else array_push($finalResult, $temp);
        }

        if($item_id != null){
            array_unshift($finalResult, $top);
        }

        $last_page = (int)ceil(sizeof($finalResult) / 10);
        $curr_page = $request->page;

        return response()->json([
            'LastPage' => $last_page,
            'CurrPage' => $curr_page,
            'ReviewCount' => $reviews->count(),
            'CompanyRating' => $reviews->avg('star'),
            'datas' => array_slice($finalResult, ($curr_page-1)*10, 10)
        ]);
    }

}
