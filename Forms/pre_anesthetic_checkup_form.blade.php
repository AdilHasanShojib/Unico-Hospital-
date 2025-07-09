<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<style>
    *,
    *::after,
    *::before {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    body {
        margin: 0;
        /* font-size: 14px; */
        /* background: #F4F3FE; */
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    ol,
    li,
    a {
        margin-bottom: 0;
        list-style: none;
    }

    a,
    a:hover {
        text-decoration: none;
    }

    .anaesthetic__form {
        padding: 25px 0px;
        position: relative;


    }

    .anaesthetic__form fieldset {
        display: block;
        margin-inline-start: 2px;
        margin-inline-end: 2px;
        padding-block-start: 0.35em;
        padding-inline-start: 0.75em;
        padding-inline-end: 0.75em;
        padding-block-end: 0.625em;
        min-inline-size: min-content;
        border-width: 1px;
        border-style: groove;
        border-color: #ffffff5e;
        border-image: initial;
    }

    .anaesthetic__form legend {
        display: block;
        padding-inline-start: 2px;
        padding-inline-end: 2px;
        border-width: initial;
        border-style: none;
        border-color: initial;
        border-image: initial;
        width: auto;
        font-size: 18px;
        font-weight: 600;
    }

    .anaesthetic__form .card {
        background-color: #fff0;

    }

    .col-form-label {
        font-size: 14px !important;
        font-weight: 700;
        color: #33449d;
    }

    img {
        max-width: 100%;
    }

    .header-info {
        float: right;
        overflow: hidden;
    }

    .header-info h1 {
        font-size: 35px;
        font-weight: 800;
        color: #970307;
    }

    .header-info h6 {
        font-size: 12px;
        font-weight: 400;
        font-style: italic;
    }

    .header-info p {
        font-size: 14px;
        font-weight: 500;
    }

    .card-header h4.card-title {
        font-size: 18px;
        font-weight: 600;
        color: #c9272b;
    }

    .capital_letter {
        display: block;
        text-align: center;
        font-size: 14px;
        font-weight: 500;
        color: #33449d;
    }

    .custom-file-input:lang(en)~.custom-file-label::after {
        content: "Upload";
    }

    .modal_link {
        text-decoration: underline;
        cursor: pointer;
    }

    .btn {
        display: inline-block;
        padding: 5px 15px;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        border-radius: 3px;
        transition: all 0.3s linear;
    }

    .btn-draft {
        background: #277ff5;
        border: 1px solid #277ff5;

    }

    .btn-preview {
        background: #2E2E2E;
        border: 1px solid #2E2E2E;
    }

    .btn-submit {
        background: #0066A2;
        border: 1px solid #0066A2;

    }

    .btn-draft:hover,
    .btn-preview:hover,
    .btn-submit:hover {
        background: transparent;
        color: #333;
    }


    .attested_section li {
        list-style: inside !important;
        font-size: 14px;
        font-weight: 400;
    }

    .custom-checkbox span {
        font-weight: 500;
        transition: all 0.3s;
    }

    .custom-checkbox span:hover {
        color: #33449d;
    }

    @media (max-width: 767px) {
        .admission_form img {
            max-width: 60%;
            display: block;
            margin: auto;
        }

        .header-info h1 {
            font-size: 25px;
            margin-top: 20px;
        }
    }

    .redactor_editor {
        min-height: 450px !important;
    }

    #cke_1_contents {
        min-height: 100px;
        width: 630px;
    }

    th,
    td {
        padding: 5px;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Pre Anesthesia Checkup Form</h5>
                <small>Report / Pre Anesthesia Checkup Form</small>
            </div>
        </div>
        {{-- @dd($anaesthetist_record_data) --}}
        <div class="anaesthetic__form">
            <form action="{{ route('pre-anesthetic-checkup-store') }}" method="post" id="PREANESTHETICCHECKUP">
                @csrf
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_fk) ? $pat_info->patient_no_fk : '' }}">
                <input type="hidden" name="pre_anesthetics_checkup_no_pk"
                    value="{{ isset($pre_anesthetic_checkup->pre_anesthetics_checkup_no_pk) ? $pre_anesthetic_checkup->pre_anesthetics_checkup_no_pk : '' }}">
                <div class="">

                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <!-- 1st card body -->
                                <div class="card-header text-center">
                                    <h2 class="card-title mb-0 text-left"> <strong> Patient Info</strong></h2>
                                </div>
                                <div class="card-body p-3">
                                    <div class="form-row" style="border: 1px solid #298949; padding: 10px;">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="regNo" class="col-form-label col-form-label-sm">UHID No:
                                                    </label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="regNo" name="regNo"
                                                    value="{{ isset($pat_info->patient_code) ? $pat_info->patient_code : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nameOfpt" class="col-form-label col-form-label-sm">Name of
                                                    Patient</label>
                                                <input type="text" class="form-control form-control-sm" readonly
                                                    id="nameOfpt" name="nameOfpt"
                                                    value="{{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}"
                                                    placeholder="Name Of pt" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptAge"
                                                    class="col-form-label col-form-label-sm">Age</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptAge" name="ptAge"
                                                    value="{{ isset($pat_info->age) ? $pat_info->age : '' }}"
                                                    placeholder="45 Years" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptSex"
                                                    class="col-form-label col-form-label-sm">Sex</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptSex" name="ptSex"
                                                    value="{{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptUnit"
                                                    class="col-form-label col-form-label-sm">Department</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptUnit" name="ptUnit"
                                                    value="{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptWard"
                                                    class="col-form-label col-form-label-sm">Cabin</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptWard" name="ptWard"
                                                    value="{{ isset($pat_info->new_ward_name) ? $pat_info->new_ward_name : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptBed"
                                                    class="col-form-label col-form-label-sm">Bed</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptBed" name="ptBed"
                                                    value="{{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="date"
                                                    class="col-form-label col-form-label-sm">Date</label>
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="date" name="date"
                                                    value="{{ @$pre_anesthetic_checkup->date ? date('Y-m-d', strtotime(@$pre_anesthetic_checkup->date)) : date('Y-m-d') }}"
                                                    placeholder="YYYY-mm-dd" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="ptBed" class="col-form-label col-form-label-sm">Name of
                                                    Treating Doctor</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="doctor_name" name="doctor_name" placeholder="Dr. Name"
                                                    value="{{ isset($pre_anesthetic_checkup->doctor_name) ? $pre_anesthetic_checkup->doctor_name : '' }}" />
                                                <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id"
                                                    value="{{ isset($pre_anesthetic_checkup->doctor_no_fk) ? $pre_anesthetic_checkup->doctor_no_fk : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 1st card body -->
                                <!-- 2nd card body -->

                                <div class="card-body p-3">
                                    <div class="">
                                        <table width="100%" border="1">
                                            <tr>
                                                <td style="width: 250px">Preoperative Diagnosis</td>
                                                <td> <input type="text" class="form-control form-control  "
                                                        id="Preoperative_Diagnosis" name="Preoperative_Diagnosis"
                                                        value="{{ isset($pre_anesthetic_checkup->preoperative_diagnosis) ? $pre_anesthetic_checkup->preoperative_diagnosis : '' }}" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 200px">Date of Surgery</td>
                                                <td>
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker"
                                                        id="scheduled_for_surgery" name="scheduled_for_surgery"
                                                        value="{{ isset($pre_anesthetic_checkup->scheduled_surgery_date) ? date('d-m-Y', strtotime($pre_anesthetic_checkup->scheduled_surgery_date)) : '' }}"
                                                        placeholder="dd-mm-YYYY" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px">Surgery</td>
                                                <td>
                                                    <label for="elective"> Elective </label> <input type="radio"
                                                        name="operation" id="elective" value="Elective"
                                                        {{ isset($pre_anesthetic_checkup->operation) && $pre_anesthetic_checkup->operation == 'Elective' ? 'checked' : '' }}>
                                                    <label for="emergency"> Emergency </label><input type="radio"
                                                        name="operation" id="emergency" value="Emergency"
                                                        {{ isset($pre_anesthetic_checkup->operation) && $pre_anesthetic_checkup->operation == 'Emergency' ? 'checked' : '' }}>
                                                </td>
                                            </tr>

                                        </table>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td style="">
                                                    <strong> Height : </strong> <input type="text"
                                                        class="form-control form-control  " id="height"
                                                        name="height"
                                                        value="{{ isset($pre_anesthetic_checkup->height) ? $pre_anesthetic_checkup->height : '' }}"
                                                        placeholder="cm" />
                                                </td>
                                                <td style="">
                                                    <strong> Weight : </strong> <input type="text"
                                                        class="form-control form-control  " id="weight"
                                                        name="weight"
                                                        value="{{ isset($pre_anesthetic_checkup->weight) ? $pre_anesthetic_checkup->weight : '' }}"
                                                        placeholder="Kg" />
                                                </td>

                                                <td style="">
                                                    <strong> BMI : </strong> <input type="text"
                                                        class="form-control form-control  " id="bmi"
                                                        name="bmi"
                                                        value="{{ isset($pre_anesthetic_checkup->bmi) ? $pre_anesthetic_checkup->bmi : '' }}"
                                                        placeholder="Kg/m2 " />
                                                </td>
                                                <td style="">
                                                    <strong>Blood Group</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="ptBlood" name="ptBlood"
                                                        value="{{ isset($pat_info->blood_group_text) ? $pat_info->blood_group_text : '' }}"
                                                        placeholder="" readonly />
                                                </td>
                                            </tr>
                                            <tr>

                                                <td style="">
                                                    <strong> Smooker : </strong> <br>
                                                    <label for="smooker_1">Yes</label> <input type="radio"
                                                        name="smooker" id="smooker_1" value="Yes"
                                                        {{ isset($pre_anesthetic_checkup->smooker) && $pre_anesthetic_checkup->smooker == 'Yes' ? 'checked' : '' }}>
                                                    <label for="smooker_2">No</label> <input type="radio"
                                                        name="smooker" id="smooker_2" value="No"
                                                        {{ isset($pre_anesthetic_checkup->smooker) && $pre_anesthetic_checkup->smooker == 'No' ? 'checked' : '' }}>
                                                </td>

                                                <td style="">
                                                    <strong> Alcohol : </strong> <br>
                                                    <label for="alcohol_1">Yes</label> <input type="radio"
                                                        name="alcohol" id="alcohol_1" value="Yes"
                                                        {{ isset($pre_anesthetic_checkup->alcohol) && $pre_anesthetic_checkup->alcohol == 'Yes' ? 'checked' : '' }}>
                                                    <label for="alcohol_2">No</label> <input type="radio"
                                                        name="alcohol" id="alcohol_2" value="No"
                                                        {{ isset($pre_anesthetic_checkup->alcohol) && $pre_anesthetic_checkup->alcohol == 'No' ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <strong> Artificial Denture : </strong> <br>
                                                    <label for="artificial_1">Yes</label> <input type="radio"
                                                        name="artificial" id="artificial_1" value="Yes"
                                                        {{ isset($pre_anesthetic_checkup->airway_artificial_denture) && $pre_anesthetic_checkup->airway_artificial_denture == 'Yes' ? 'checked' : '' }}>
                                                    <label for="artificial_2">No</label> <input type="radio"
                                                        name="artificial" id="artificial_2" value="No"
                                                        {{ isset($pre_anesthetic_checkup->airway_artificial_denture) && $pre_anesthetic_checkup->airway_artificial_denture == 'No' ? 'checked' : '' }}>

                                                </td>

                                            </tr>
                                        </table>

                                        <table width="100%" border="1" style="margin-top:10px">

                                            <tr>
                                                <td colspan="1" style="width: 300px;">
                                                    <strong>Previous Anesthesia Complication (if any)</strong>
                                                </td>
                                                <td>

                                                    <input type="text" class="form-control form-control-sm"
                                                        id="previous_anesthesia_and_complication"
                                                        name="previous_anesthesia_and_complication"
                                                        value="{{ isset($pre_anesthetic_checkup->pre_anes_and_comp) ? $pre_anesthetic_checkup->pre_anes_and_comp : '' }}"
                                                        placeholder="" />
                                                </td>
                                            </tr>
                                        </table>






                                        <br>
                                        <h2>Co-existing disease with duration :</h2>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td style="">
                                                    <strong> Hypertension : </strong> <input type="text"
                                                        class="form-control form-control  " id="hypertension"
                                                        name="hypertension"
                                                        value="{{ isset($pre_anesthetic_checkup->hypertension) ? $pre_anesthetic_checkup->hypertension : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td style="">
                                                    <strong> IHD : </strong> <input type="text"
                                                        class="form-control form-control  " id="ihd"
                                                        name="ihd"
                                                        value="{{ isset($pre_anesthetic_checkup->ihd) ? $pre_anesthetic_checkup->ihd : '' }}"
                                                        placeholder="" />
                                                </td>

                                                <td style="">
                                                    <strong> Myocardial Infarction: </strong> <input type="text"
                                                        class="form-control form-control  " id="myocardial"
                                                        name="myocardial"
                                                        value="{{ isset($pre_anesthetic_checkup->myocardial) ? $pre_anesthetic_checkup->myocardial : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td style="">
                                                    <strong> Bronchial Asthma/COPD : </strong> <input type="text"
                                                        class="form-control form-control  " id="asthma"
                                                        name="asthma"
                                                        value="{{ isset($pre_anesthetic_checkup->asthma) ? $pre_anesthetic_checkup->asthma : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td style="">
                                                    <strong>Diabetes:</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="diabetes" name="diabetes"
                                                        value="{{ isset($pre_anesthetic_checkup->diabetes) ? $pre_anesthetic_checkup->diabetes : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td style="">
                                                    <strong>Thyroid disorder:</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="thyroid_disorder" name="thyroid_disorder"
                                                        value="{{ isset($pre_anesthetic_checkup->thyroid_disorder) ? $pre_anesthetic_checkup->thyroid_disorder : '' }}"
                                                        placeholder="" />
                                                </td>

                                            </tr>

                                            <tr>

                                                <td style="">

                                                    <strong> Cough : </strong> <br>
                                                    <label for="pre_cough_1">Dyspnea</label> <input type="radio"
                                                        name="pre_cough" id="pre_cough_1" value="Dyspnea"
                                                        {{ isset($pre_anesthetic_checkup->pre_cough) && $pre_anesthetic_checkup->pre_cough == 'Dyspnea' ? 'checked' : '' }}>
                                                    <label for="pre_cough_2">Chest</label> <input type="radio"
                                                        name="pre_cough" id="pre_cough_2" value="Chest"
                                                        {{ isset($pre_anesthetic_checkup->pre_cough) && $pre_anesthetic_checkup->pre_cough == 'Chest' ? 'checked' : '' }}>
                                                </td>

                                                <td style="">
                                                    <strong> Chest Pain: </strong> <input type="text"
                                                        class="form-control form-control  " id="chestpain"
                                                        name="chestpain"
                                                        value="{{ isset($pre_anesthetic_checkup->chestpain) ? $pre_anesthetic_checkup->chestpain : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td  colspan="4">
                                                    <strong>Others:</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="others_medical_problem" name="others_medical_problem"
                                                        value="{{ isset($pre_anesthetic_checkup->others_medical_problem) ? $pre_anesthetic_checkup->others_medical_problem : '' }}"
                                                        placeholder="" />
                                                </td>

                                            </tr>

                                            <tr>
                                                <td colspan="1" style="width: 300px;">
                                                    <strong> Present Medication : </strong>
                                                </td>
                                                <td colspan="5">
                                                    <input type="text" class="form-control  "
                                                        id="present_medication" name="present_medication"
                                                        value="{{ isset($pre_anesthetic_checkup->present_medication) ? $pre_anesthetic_checkup->present_medication : '' }}" />

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> Allergy : </strong>
                                                </td>
                                                <td colspan="5">
                                                    <input type="text" class="form-control  " id="allergy"
                                                        name="allergy"
                                                        value="{{ isset($pre_anesthetic_checkup->allergy) ? $pre_anesthetic_checkup->allergy : '' }}" />
                                                </td>
                                            </tr>

                                        </table>



                                        <br>
                                        <h2>Investigations</h2> <br>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <h4>CBC-</h4>
                                                <td>
                                                    <strong> HB</strong>
                                                    <input type="text" class="form-control" id="hb_pcv"
                                                        name="hb_pcv"
                                                        value="{{ isset($pre_anesthetic_checkup->hb_pcv) ? $pre_anesthetic_checkup->hb_pcv : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> PCV</strong>
                                                    <input type="text" class="form-control" id="pcv"
                                                        name="pcv"
                                                        value="{{ isset($pre_anesthetic_checkup->pcv) ? $pre_anesthetic_checkup->pcv : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> TC</strong>
                                                    <input type="text" class="form-control" id="tc"
                                                        name="tc"
                                                        value="{{ isset($pre_anesthetic_checkup->tc) ? $pre_anesthetic_checkup->tc : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Platelet </strong>
                                                    <input type="text" class="form-control" id="platelet_count"
                                                        name="platelet_count"
                                                        value="{{ isset($pre_anesthetic_checkup->platelet_count) ? $pre_anesthetic_checkup->platelet_count : '' }}" />
                                                </td>


                                            </tr>

                                        </table>


                                        <table width="100%" border="1" style="margin-top:10px">

                                            <tr>
                                                <br>
                                                <h4>Blood Sugar-</h4>
                                                <td>
                                                    <strong>FBS</strong>
                                                    <input type="text" class="form-control" id="fbs_rbs"
                                                        name="fbs_rbs"
                                                        value="{{ isset($pre_anesthetic_checkup->fbs_rbs) ? $pre_anesthetic_checkup->fbs_rbs : '' }}" />
                                                </td>

                                                <td>
                                                    <strong>RBS</strong>
                                                    <input type="text" class="form-control" id="rbs"
                                                        name="rbs"
                                                        value="{{ isset($pre_anesthetic_checkup->rbs) ? $pre_anesthetic_checkup->rbs : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>HbA1C</strong>
                                                    <input type="text" class="form-control" id="hba1c"
                                                        name="hba1c"
                                                        value="{{ isset($pre_anesthetic_checkup->hba1c) ? $pre_anesthetic_checkup->hba1c : '' }}" />
                                                </td>


                                                <td>
                                                    <strong>S. Creat.</strong>
                                                    <input type="text" class="form-control" id="screatinine"
                                                        name="screatinine"
                                                        value="{{ isset($pre_anesthetic_checkup->screatinine) ? $pre_anesthetic_checkup->screatinine : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>Bl. Urea</strong>
                                                    <input type="text" class="form-control" id="urea"
                                                        name="urea"
                                                        value="{{ isset($pre_anesthetic_checkup->urea) ? $pre_anesthetic_checkup->urea : '' }}" />
                                                </td>


                                            </tr>


                                        </table>

                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>Electrolyte-</h4>
                                            <tr>
                                                <td>
                                                    <strong>Na</strong>
                                                    <input type="text" class="form-control" id="na"
                                                        name="na"
                                                        value="{{ isset($pre_anesthetic_checkup->na) ? $pre_anesthetic_checkup->na : '' }}" />
                                                </td>
                                                <td>

                                                    <strong>K</strong>
                                                    <input type="text" class="form-control" id="k"
                                                        name="k"
                                                        value="{{ isset($pre_anesthetic_checkup->k) ? $pre_anesthetic_checkup->k : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>CL</strong>
                                                    <input type="text" class="form-control" id="cl"
                                                        name="cl"
                                                        value="{{ isset($pre_anesthetic_checkup->cl) ? $pre_anesthetic_checkup->cl : '' }}" />
                                                </td>

                                                <td>
                                                    <strong>Ca</strong>
                                                    <input type="text" class="form-control" id="ca"
                                                        name="ca"
                                                        value="{{ isset($pre_anesthetic_checkup->ca) ? $pre_anesthetic_checkup->ca : '' }}" />
                                                </td>


                                            </tr>





                                        </table>



                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>Coagulation-</h4>

                                            <tr>
                                                <td>
                                                    <strong>PT</strong>
                                                    <input type="text" class="form-control" id="pt"
                                                        name="pt"
                                                        value="{{ isset($pre_anesthetic_checkup->pt) ? $pre_anesthetic_checkup->pt : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>APTT</strong>
                                                    <input type="text" class="form-control" id="aptt"
                                                        name="aptt"
                                                        value="{{ isset($pre_anesthetic_checkup->aptt) ? $pre_anesthetic_checkup->aptt : '' }}" />
                                                </td>

                                                <td>
                                                    <strong>INR</strong>
                                                    <input type="text" class="form-control" id="inr"
                                                        name="inr"
                                                        value="{{ isset($pre_anesthetic_checkup->inr) ? $pre_anesthetic_checkup->inr : '' }}" />
                                                </td>

                                                <td>
                                                    <strong>BT</strong>
                                                    <input type="text" class="form-control" id="bt"
                                                        name="bt"
                                                        value="{{ isset($pre_anesthetic_checkup->bt) ? $pre_anesthetic_checkup->bt : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>CT</strong>
                                                    <input type="text" class="form-control" id="ct"
                                                        name="ct"
                                                        value="{{ isset($pre_anesthetic_checkup->ct) ? $pre_anesthetic_checkup->ct : '' }}" />
                                                </td>


                                            </tr>





                                        </table>



                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>ABG-</h4>


                                            <tr>
                                                <td>
                                                    <strong>pH</strong>
                                                    <input type="text" class="form-control" id="ph"
                                                        name="ph"
                                                        value="{{ isset($pre_anesthetic_checkup->ph) ? $pre_anesthetic_checkup->ph : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>PaO <sub>2</sub></strong>
                                                    <input type="text" class="form-control" id="pao2"
                                                        name="pao2"
                                                        value="{{ isset($pre_anesthetic_checkup->pao2) ? $pre_anesthetic_checkup->pao2 : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>PaCO <sub>2</sub></strong>
                                                    <input type="text" class="form-control" id="paco2"
                                                        name="paco2"
                                                        value="{{ isset($pre_anesthetic_checkup->paco2) ? $pre_anesthetic_checkup->paco2 : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>HCO</strong> <sub>3</sub>
                                                    <input type="text" class="form-control" id="hco3"
                                                        name="hco3"
                                                        value="{{ isset($pre_anesthetic_checkup->hco3) ? $pre_anesthetic_checkup->hco3 : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>BE</strong>
                                                    <input type="text" class="form-control" id="be"
                                                        name="be"
                                                        value="{{ isset($pre_anesthetic_checkup->be) ? $pre_anesthetic_checkup->be : '' }}" />
                                                </td>

                                                <td>
                                                    <strong> HbsAg</strong>
                                                    <input type="text" class="form-control" id="hbsag"
                                                        name="hbsag"
                                                        value="{{ isset($pre_anesthetic_checkup->hbsag) ? $pre_anesthetic_checkup->hbsag : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> HCB</strong>
                                                    <input type="text" class="form-control" id="hcv"
                                                        name="hcv"
                                                        value="{{ isset($pre_anesthetic_checkup->hcv) ? $pre_anesthetic_checkup->hcv : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>HIV</strong>
                                                    <input type="text" class="form-control" id="hiv"
                                                        name="hiv"
                                                        value="{{ isset($pre_anesthetic_checkup->hiv) ? $pre_anesthetic_checkup->hiv : '' }}" />
                                                </td>



                                            </tr>





                                        </table>



                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>TFT-</h4>

                                            <tr>
                                                <td>
                                                    <strong>T3</strong>
                                                    <input type="text" class="form-control" id="T3_t4"
                                                        name="T3_t4"
                                                        value="{{ isset($pre_anesthetic_checkup->t3_t4) ? $pre_anesthetic_checkup->t3_t4 : '' }}" />
                                                </td>

                                                <td>
                                                    <strong>T4</strong>
                                                    <input type="text" class="form-control" id="t4"
                                                        name="t4"
                                                        value="{{ isset($pre_anesthetic_checkup->t4) ? $pre_anesthetic_checkup->t4 : '' }}" />
                                                </td>


                                                <td>

                                                    <strong>TSH</strong>
                                                    <input type="text" class="form-control" id="tsh"
                                                        name="tsh"
                                                        value="{{ isset($pre_anesthetic_checkup->tsh) ? $pre_anesthetic_checkup->tsh : '' }}" />
                                                </td>


                                            </tr>





                                        </table>

                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>LFT-</h4>

                                            <tr>
                                                <td>
                                                    <strong>Alt</strong>
                                                    <input type="text" class="form-control" id="alt"
                                                        name="alt"
                                                        value="{{ isset($pre_anesthetic_checkup->alt) ? $pre_anesthetic_checkup->alt : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>Ast</strong>
                                                    <input type="text" class="form-control" id="ast"
                                                        name="ast"
                                                        value="{{ isset($pre_anesthetic_checkup->ast) ? $pre_anesthetic_checkup->ast : '' }}" />
                                                </td>


                                                <td>

                                                    <strong>Alk Ph</strong>
                                                    <input type="text" class="form-control" id="alkph"
                                                        name="alkph"
                                                        value="{{ isset($pre_anesthetic_checkup->alkph) ? $pre_anesthetic_checkup->alkph : '' }}" />
                                                </td>
                                                <td>

                                                    <strong>T.Bilirubin</strong>
                                                    <input type="text" class="form-control" id="bilirubin"
                                                        name="bilirubin"
                                                        value="{{ isset($pre_anesthetic_checkup->sbilirubin) ? $pre_anesthetic_checkup->sbilirubin : '' }}" />
                                                </td>

                                            </tr>





                                        </table>


                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>T.Protein-</h4>
                                            <tr>
                                                <td>
                                                    <strong>Ab</strong>
                                                    <input type="text" class="form-control" id="ab"
                                                        name="ab"
                                                        value="{{ isset($pre_anesthetic_checkup->ab) ? $pre_anesthetic_checkup->ab : '' }}" />
                                                </td>

                                                <td>
                                                    <strong>Glob</strong>
                                                    <input type="text" class="form-control" id="glob"
                                                        name="glob"
                                                        value="{{ isset($pre_anesthetic_checkup->glob) ? $pre_anesthetic_checkup->glob : '' }}" />
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="1" style="margin-top:10px">

                                            <tr>
                                                <td>
                                                    <strong>CXR</strong>
                                                    <input type="text" class="form-control" id="cxr"
                                                        name="cxr"
                                                        value="{{ isset($pre_anesthetic_checkup->cxr) ? $pre_anesthetic_checkup->cxr : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>ECG</strong>
                                                    <input type="text" class="form-control" id="ecg"
                                                        name="ecg"
                                                        value="{{ isset($pre_anesthetic_checkup->ecg) ? $pre_anesthetic_checkup->ecg : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>Echo</strong>
                                                    <input type="text" class="form-control" id="echo"
                                                        name="echo"
                                                        value="{{ isset($pre_anesthetic_checkup->echo) ? $pre_anesthetic_checkup->echo : '' }}" />
                                                </td>



                                                <td>
                                                    <strong> Others : </strong>

                                                    <input type="text" class="form-control  " id="others"
                                                        name="others"
                                                        value="{{ isset($pre_anesthetic_checkup->others) ? $pre_anesthetic_checkup->others : '' }}" />
                                                </td>

                                            </tr>

                                        </table>

                                        <br>
                                        <h2>Vital Signs</h2>

                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td>
                                                    <strong> Pulse : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control  " id="pulse"
                                                        name="pulse"
                                                        value="{{ isset($pre_anesthetic_checkup->pulse) ? $pre_anesthetic_checkup->pulse : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Jaundice : </strong>
                                                </td>
                                                <td>
                                                    <input type="radio" value="(-) ve" name="jaundice"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->jaundice) && $pre_anesthetic_checkup->jaundice == '(-) ve' ? 'checked' : '' }}>
                                                    (-) ve
                                                    <input type="radio" value="(+) ve" name="jaundice"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->jaundice) && $pre_anesthetic_checkup->jaundice == '(+) ve' ? 'checked' : '' }}>
                                                    (+) ve
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> BP : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control  " id="bp"
                                                        name="bp"
                                                        value="{{ isset($pre_anesthetic_checkup->bp) ? $pre_anesthetic_checkup->bp : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Cyanosis : </strong>
                                                </td>
                                                <td>
                                                    <input type="radio" value="(-) ve" name="cyanosis"
                                                        id="cyanosis"
                                                        {{ isset($pre_anesthetic_checkup->cyanosis) && $pre_anesthetic_checkup->cyanosis == '(-) ve' ? 'checked' : '' }}>
                                                    (-) ve
                                                    <input type="radio" value="(+) ve" name="cyanosis"
                                                        id="cyanosis"
                                                        {{ isset($pre_anesthetic_checkup->cyanosis) && $pre_anesthetic_checkup->cyanosis == '(+) ve' ? 'checked' : '' }}>
                                                    (+) ve
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> Temperature : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control  " id="temperature"
                                                        name="temperature"
                                                        value="{{ isset($pre_anesthetic_checkup->temperature) ? $pre_anesthetic_checkup->temperature : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Odema : </strong>
                                                </td>
                                                <td>
                                                    <input type="radio" value="(-) ve" name="oedema"
                                                        id="oedema"
                                                        {{ isset($pre_anesthetic_checkup->oedema) && $pre_anesthetic_checkup->oedema == '(-) ve' ? 'checked' : '' }}>
                                                    (-) ve
                                                    <input type="radio" value="(+) ve" name="oedema"
                                                        id="oedema"
                                                        {{ isset($pre_anesthetic_checkup->oedema) && $pre_anesthetic_checkup->oedema == '(+) ve' ? 'checked' : '' }}>
                                                    (+) ve
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> SPO<sub>2</sub> : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control  " id="spo2"
                                                        name="spo2"
                                                        value="{{ isset($pre_anesthetic_checkup->spo2) ? $pre_anesthetic_checkup->spo2 : '' }}" />
                                                </td>

                                                <td>
                                                    <strong> Cough : </strong>
                                                </td>
                                                <td>
                                                    <input type="radio" value="(-) ve" name="cough"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->cough) && $pre_anesthetic_checkup->cough == '(-) ve' ? 'checked' : '' }}>
                                                    (-) ve
                                                    <input type="radio" value="(+) ve" name="cough"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->cough) && $pre_anesthetic_checkup->cough == '(+) ve' ? 'checked' : '' }}>
                                                    (+) ve
                                                </td>


                                            </tr>
                                            <tr>

                                                <td>
                                                    <strong> Anemia : </strong>
                                                </td>


                                                <td>
                                                    <input type="text" class="form-control  " id="anemia"
                                                        name="anemia"
                                                        value="{{ isset($pre_anesthetic_checkup->anemia) ? $pre_anesthetic_checkup->anemia : '' }}" />

                                                </td>
                                            </tr>
                                            <tr>


                                                <td>
                                                    <strong> Others : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" name="clinical_exam_others"
                                                        id="clinical_exam_others" class="form-control"
                                                        value="{{ isset($pre_anesthetic_checkup->clinical_exam_others) ? $pre_anesthetic_checkup->clinical_exam_others : '' }}">
                                                </td>
                                            </tr>
                                        </table>


                                        <br>
                                        <h2>Airway Assessment</h2>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>

                                                <td>
                                                    <strong>Mouth opening > 2 fingers : </strong>
                                                    <input type="text" class="form-control  " id="mouth_opening"
                                                        name="mouth_opening"
                                                        value="{{ isset($pre_anesthetic_checkup->mouth_opening) ? $pre_anesthetic_checkup->mouth_opening : '' }}"
                                                        placeholder="Yes or No" />

                                                </td>
                                                <td>
                                                    <strong>Thyromental distance > 2 fingers: </strong>
                                                    <input type="text" class="form-control  "
                                                        id="thyromental_distance" name="thyromental_distance"
                                                        value="{{ isset($pre_anesthetic_checkup->thyromental_distance) ? $pre_anesthetic_checkup->thyromental_distance : '' }}"
                                                        placeholder="Yes or No" />

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> Neck Movement : </strong>
                                                    <input type="text" class="form-control  " id="neck_movement"
                                                        name="neck_movement"
                                                        value="{{ isset($pre_anesthetic_checkup->neck_movement) ? $pre_anesthetic_checkup->neck_movement : '' }}"
                                                        placeholder="Full or Restricted" />
                                                </td>

                                                <td>
                                                    <strong> Short Neck : </strong>
                                                    <input type="text" class="form-control  " id="short_neck"
                                                        name="short_neck"
                                                        value="{{ isset($pre_anesthetic_checkup->short_neck) ? $pre_anesthetic_checkup->short_neck : '' }}"
                                                        placeholder="Yes or No" />

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> Neck Swelling : </strong>
                                                    <input type="text" class="form-control  " id="neck_swelling"
                                                        name="neck_swelling"
                                                        value="{{ isset($pre_anesthetic_checkup->neck_swelling) ? $pre_anesthetic_checkup->neck_swelling : '' }}"
                                                        placeholder="Yes or No" />

                                                </td>
                                                <td>
                                                    <strong>Artificial denture: </strong>
                                                    <input type="text" class="form-control  "
                                                        id="artificial_denture" name="artificial_denture"
                                                        value="{{ isset($pre_anesthetic_checkup->artificial_denture) ? $pre_anesthetic_checkup->artificial_denture : '' }}"
                                                        placeholder="Yes or No" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> Others : </strong>
                                                    <input type="text" class="form-control  " id="airway_others"
                                                        name="airway_others"
                                                        value="{{ isset($pre_anesthetic_checkup->airway_others) ? $pre_anesthetic_checkup->airway_others : '' }}" />
                                                </td>


                                                <td>
                                                    <strong> Mallampati Grade : </strong>

                                                    <input type="radio" value="I" name="mallampati_score"
                                                        id="mallampati_score"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_score) && $pre_anesthetic_checkup->mallampati_score == 'I' ? 'checked' : '' }}>
                                                    I &nbsp;&nbsp;
                                                    <input type="radio" value="II" name="mallampati_score"
                                                        id="mallampati_score"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_score) && $pre_anesthetic_checkup->mallampati_score == 'II' ? 'checked' : '' }}>
                                                    II &nbsp;&nbsp;
                                                    <input type="radio" value="III" name="mallampati_score"
                                                        id="mallampati_score"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_score) && $pre_anesthetic_checkup->mallampati_score == 'III' ? 'checked' : '' }}>
                                                    III &nbsp;&nbsp;
                                                    <input type="radio" value="IV" name="mallampati_score"
                                                        id="mallampati_score"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_score) && $pre_anesthetic_checkup->mallampati_score == 'IV' ? 'checked' : '' }}>
                                                    IV
                                                </td>


                                            </tr>


                                        </table>




                                        <br>
                                        <h2>Systemic Examination</h2>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td>
                                                    <strong> Central Nervous system : </strong>
                                                    <input type="text" class="form-control  " id="cns"
                                                        name="cns"
                                                        value="{{ isset($pre_anesthetic_checkup->cns) ? $pre_anesthetic_checkup->cns : '' }}" />
                                                </td>

                                                <td>
                                                    <strong> Cardiovascular system : </strong>
                                                    <input type="text" class="form-control  " id="cvs"
                                                        name="cvs"
                                                        value="{{ isset($pre_anesthetic_checkup->cvs) ? $pre_anesthetic_checkup->cvs : '' }}" />
                                                </td>

                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> Respiratory System : </strong>
                                                    <input type="text" class="form-control  "
                                                        id="respiratory_system" name="respiratory_system"
                                                        value="{{ isset($pre_anesthetic_checkup->respiratory_system) ? $pre_anesthetic_checkup->respiratory_system : '' }}" />
                                                </td>

                                                <td>
                                                    <strong> Others : </strong>
                                                    <input type="text" class="form-control  " id="systemic_others"
                                                        name="systemic_others"
                                                        value="{{ isset($pre_anesthetic_checkup->systemic_others) ? $pre_anesthetic_checkup->systemic_others : '' }}" />
                                                </td>

                                            </tr>

                                        </table>
                                        <br>
                                        <h2>Consideration for Operating Room Anesthesiologist:</h2>
                                        <table width="100%" border="1" style="margin-top:10px">

                                            <tr>

                                                <td>
                                                    <strong>Artificial denture: </strong>
                                                    <input type="text" class="form-control  "
                                                        id="coniser_artificial_denture" name="coniser_artificial_denture"
                                                        value="{{ isset($pre_anesthetic_checkup->coniser_artificial_denture) ? $pre_anesthetic_checkup->coniser_artificial_denture : '' }}"
                                                        placeholder="Yes or No" />
                                                </td>

                                                <td colspan="2">
                                                    <strong> Airway Assessment : </strong>
                                                    <input type="text" class="form-control  "
                                                        id="airway_examination" name="airway_examination"
                                                        value="{{ isset($pre_anesthetic_checkup->airway_exam) ? $pre_anesthetic_checkup->airway_exam : '' }}"
                                                        placeholder="Normal / Difficult " />

                                                </td>
                                            </tr>

                                            <tr>

                                                <td colspan="3">
                                                    <strong>Co-Existing Disease: </strong>
                                                    <input type="text" class="form-control  " id="co_existing"
                                                        name="co_existing"
                                                        value="{{ isset($pre_anesthetic_checkup->co_existing) ? $pre_anesthetic_checkup->co_existing : '' }}"
                                                        placeholder="" />
                                                </td>

                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> ASA : </strong>
                                                    <input type="radio" value="1" name="asa_class"
                                                        id="asa_class"
                                                        {{ isset($pre_anesthetic_checkup->asa_class) && $pre_anesthetic_checkup->asa_class == '1' ? 'checked' : '' }}>
                                                    1 &nbsp;&nbsp;
                                                    <input type="radio" value="2" name="asa_class"
                                                        id="asa_class"
                                                        {{ isset($pre_anesthetic_checkup->asa_class) && $pre_anesthetic_checkup->asa_class == '2' ? 'checked' : '' }}>
                                                    2 &nbsp;&nbsp;
                                                    <input type="radio" value="3" name="asa_class"
                                                        id="asa_class"
                                                        {{ isset($pre_anesthetic_checkup->asa_class) && $pre_anesthetic_checkup->asa_class == '3' ? 'checked' : '' }}>
                                                    3 &nbsp;&nbsp;
                                                    <input type="radio" value="4" name="asa_class"
                                                        id="asa_class"
                                                        {{ isset($pre_anesthetic_checkup->asa_class) && $pre_anesthetic_checkup->asa_class == '4' ? 'checked' : '' }}>
                                                    4 &nbsp;&nbsp;
                                                    <input type="radio" value="5" name="asa_class"
                                                        id="asa_class"
                                                        {{ isset($pre_anesthetic_checkup->asa_class) && $pre_anesthetic_checkup->asa_class == '5' ? 'checked' : '' }}>
                                                    5 &nbsp;&nbsp;
                                                    <input type="radio" value="6" name="asa_class"
                                                        id="asa_class"
                                                        {{ isset($pre_anesthetic_checkup->asa_class) && $pre_anesthetic_checkup->asa_class == '6' ? 'checked' : '' }}>
                                                    6 &nbsp;&nbsp;
                                                    <input type="radio" value="E" name="asa_class"
                                                        id="asa_class"
                                                        {{ isset($pre_anesthetic_checkup->asa_class) && $pre_anesthetic_checkup->asa_class == 'E' ? 'checked' : '' }}>
                                                    E
                                                </td>
                                                <td>
                                                    <strong> NYHA : </strong>

                                                    <input type="radio" value="I" name="nyha_classification"
                                                        id="nyha_classification"
                                                        {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'I' ? 'checked' : '' }}>
                                                    I &nbsp;&nbsp;
                                                    <input type="radio" value="II" name="nyha_classification"
                                                        id="nyha_classification"
                                                        {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'II' ? 'checked' : '' }}>
                                                    II &nbsp;&nbsp;
                                                    <input type="radio" value="III" name="nyha_classification"
                                                        id="nyha_classification"
                                                        {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'III' ? 'checked' : '' }}>
                                                    III &nbsp;&nbsp;
                                                    <input type="radio" value="IV" name="nyha_classification"
                                                        id="nyha_classification"
                                                        {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'IV' ? 'checked' : '' }}>
                                                    IV
                                                </td>

                                                <td>
                                                    <strong> Mallampati grade : </strong>

                                                    <input type="radio" value="I" name="mallampati_grade"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'I' ? 'checked' : '' }}>
                                                    I &nbsp;&nbsp;
                                                    <input type="radio" value="II" name="mallampati_grade"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'II' ? 'checked' : '' }}>
                                                    II &nbsp;&nbsp;
                                                    <input type="radio" value="III" name="mallampati_grade"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'III' ? 'checked' : '' }}>
                                                    III &nbsp;&nbsp;
                                                    <input type="radio" value="IV" name="mallampati_grade"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'IV' ? 'checked' : '' }}>
                                                    IV
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <strong> Type of Anesthesia Discussed : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="radio" value="GA"
                                                        name="type_of_anesthesia_discussed" id=""
                                                        {{ isset($pre_anesthetic_checkup->type_of_anesthesia_discussed) && $pre_anesthetic_checkup->type_of_anesthesia_discussed == 'GA' ? 'checked' : '' }}>
                                                    GA &nbsp;&nbsp;
                                                    <input type="radio" value="Spinal"
                                                        name="type_of_anesthesia_discussed" id=""
                                                        {{ isset($pre_anesthetic_checkup->type_of_anesthesia_discussed) && $pre_anesthetic_checkup->type_of_anesthesia_discussed == 'Spinal' ? 'checked' : '' }}>
                                                    Spinal &nbsp;&nbsp;
                                                    <input type="radio" value="Epidural"
                                                        name="type_of_anesthesia_discussed" id=""
                                                        {{ isset($pre_anesthetic_checkup->type_of_anesthesia_discussed) && $pre_anesthetic_checkup->type_of_anesthesia_discussed == 'Epidural' ? 'checked' : '' }}>
                                                    Epidural &nbsp;&nbsp;
                                                    <input type="radio" value="Nerve Block"
                                                        name="type_of_anesthesia_discussed" id=""
                                                        {{ isset($pre_anesthetic_checkup->type_of_anesthesia_discussed) && $pre_anesthetic_checkup->type_of_anesthesia_discussed == 'Nerve Block' ? 'checked' : '' }}>
                                                    Nerve Block
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <strong> Pain Relief Discussed : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="radio" value="PCA" name="pain_relief_discussed"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->pain_relief_discussed) && $pre_anesthetic_checkup->pain_relief_discussed == 'PCA' ? 'checked' : '' }}>
                                                    PCA &nbsp;&nbsp;
                                                    <input type="radio" value="Epidural infusion"
                                                        name="pain_relief_discussed" id=""
                                                        {{ isset($pre_anesthetic_checkup->pain_relief_discussed) && $pre_anesthetic_checkup->pain_relief_discussed == 'Epidural infusion' ? 'checked' : '' }}>
                                                    Epidural infusion &nbsp;&nbsp;

                                                    <input type="radio" value="PCEA"
                                                        name="pain_relief_discussed" id=""
                                                        {{ isset($pre_anesthetic_checkup->pain_relief_discussed) && $pre_anesthetic_checkup->pain_relief_discussed == 'PCEA' ? 'checked' : '' }}>
                                                    PCEA&nbsp;&nbsp;
                                                    <input type="radio" value="Oral"
                                                        name="pain_relief_discussed" id=""
                                                        {{ isset($pre_anesthetic_checkup->pain_relief_discussed) && $pre_anesthetic_checkup->pain_relief_discussed == 'Oral' ? 'checked' : '' }}>
                                                    Oral &nbsp;&nbsp;

                                                    <input type="radio" value="IM" name="pain_relief_discussed"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->pain_relief_discussed) && $pre_anesthetic_checkup->pain_relief_discussed == 'IM' ? 'checked' : '' }}>
                                                    IM
                                                    <input type="radio" value="IV" name="pain_relief_discussed"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->pain_relief_discussed) && $pre_anesthetic_checkup->pain_relief_discussed == 'IV' ? 'checked' : '' }}>
                                                    IV
                                                    <input type="radio" value="Per rectal"
                                                        name="pain_relief_discussed" id=""
                                                        {{ isset($pre_anesthetic_checkup->pain_relief_discussed) && $pre_anesthetic_checkup->pain_relief_discussed == 'Per rectal' ? 'checked' : '' }}>
                                                    Per rectal
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <strong> Risk factor( if any) : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" name="risk_factor" class="form-control"
                                                        id="risk_factor"
                                                        value="{{ isset($pre_anesthetic_checkup->risk_factor) ? $pre_anesthetic_checkup->risk_factor : '' }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <strong>Others</strong>
                                                    <input type="text" class="form-control" id="others2"
                                                        name="others2"
                                                        value="{{ isset($pre_anesthetic_checkup->other2) ? $pre_anesthetic_checkup->other2 : '' }}" />
                                                </td>

                                            </tr>
                                        </table>
                                        <br>
                                        <h2>Pre-operative Instructions:</h2>
                                        <table width="100%" border="1" style="margin-top:10px">

                                            <tr>
                                                <td colspan="4">
                                                    <strong>1. NPO-
                                                        <input type="text" class="" id="pre_operative_ins1"
                                                            name="pre_operative_ins1"
                                                            value="{{ isset($pre_anesthetic_checkup->pre_operative_ins1) ? $pre_anesthetic_checkup->pre_operative_ins1 : '' }}" />
                                                        hours before operation/Till further order</strong>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>2. Drugs / Premedication :</strong>

                                                </td>
                                                <td colspan="3">

                                                    <input type="text" class="form-control"
                                                        id="pre_operative_ins2" name="pre_operative_ins2"
                                                        value="{{ isset($pre_anesthetic_checkup->pre_operative_ins2) ? $pre_anesthetic_checkup->pre_operative_ins2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>3. Blood Donor Standby(Cross-matched): </strong>

                                                </td>
                                                <td colspan="3">

                                                    <input type="text" class="form-control"
                                                        id="pre_operative_ins3" name="pre_operative_ins3"
                                                        value="{{ isset($pre_anesthetic_checkup->pre_operative_ins3) ? $pre_anesthetic_checkup->pre_operative_ins3 : '' }}" />
                                                    <strong> Unit</strong>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>4. Blood for Operation</strong>

                                                </td>
                                                <td>
                                                    <strong>Whole blood
                                                        <input type="text" class="form-control"
                                                            id="whole_blood"
                                                            name="whole_blood"
                                                            value="{{ $pre_anesthetic_checkup->whole_blood ?? '' }}" />
                                                        Unit
                                                    </strong>
                                                </td>

                                                <td>
                                                    <strong>Packed red blood cell
                                                        <input type="text" class="form-control"
                                                            id="red_blood"
                                                            name="red_blood"
                                                            value="{{ $pre_anesthetic_checkup->red_blood ?? '' }}" />
                                                        Unit
                                                    </strong>
                                                </td>

                                                <td>
                                                    <strong>Fresh frozen plasma
                                                        <input type="text" class="form-control"
                                                            id="fresh_frosen_plasma" name="fresh_frosen_plasma"
                                                            value="{{ $pre_anesthetic_checkup->fresh_frosen_plasma ?? '' }}" />
                                                        Unit
                                                    </strong>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>5. Further advice :</strong>

                                                </td>
                                                <td colspan="3">
                                                    <input type="text" class="form-control" id="further_advice"
                                                        name="further_advice"
                                                        value="{{ isset($pre_anesthetic_checkup->further_advice) ? $pre_anesthetic_checkup->further_advice : '' }}" />

                                                </td>
                                            </tr>
                                        </table>

                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td>
                                                    <strong>Accepted for operation Under:</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="ga" id="ga"
                                                        value="GA"
                                                        {{ isset($pre_anesthetic_checkup->ga) && $pre_anesthetic_checkup->ga == 'GA' ? 'checked' : '' }}>
                                                    GA
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="ra" id="ra"
                                                        value="RA"
                                                        {{ isset($pre_anesthetic_checkup->ra) && $pre_anesthetic_checkup->ra == 'RA' ? 'checked' : '' }}>
                                                    RA
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="monitored_care" id="monitored_care"
                                                        value="Monitored Care"
                                                        {{ isset($pre_anesthetic_checkup->monitored_care) && $pre_anesthetic_checkup->monitored_care == 'Monitored Care' ? 'checked' : '' }}>
                                                    Monitored Anesthesia Care(MAC)
                                                </td>



                                            </tr>

                                            <br>
                                        </table>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td colspan="" class="">
                                                    <label for="Anesthetist_name"
                                                        class="col-form-label col-form-label-sm">
                                                        Anesthesiologist</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="Anesthetist_name" name="Anesthetist_name"
                                                        placeholder="Dr. Name"
                                                        value="{{ isset($pre_anesthetic_checkup->full_name) ? $pre_anesthetic_checkup->full_name : '' }}" />
                                                    <input type="hidden" name="Anesthetist_no_fk"
                                                        id="Anesthetist_no_fk"
                                                        value="{{ isset($pre_anesthetic_checkup->anesthetist_id_fk) ? $pre_anesthetic_checkup->anesthetist_id_fk : '' }}">
                                                </td>

                                                <td>
                                                    <strong>Date:</strong>
                                                    <input type="date" name="anesthesia_date"
                                                        value="{{ @$pre_anesthetic_checkup->anesthesia_date ? date('Y-m-d', strtotime(@$pre_anesthetic_checkup->anesthesia_date)) : date('Y-m-d') }}"
                                                        autocomplete="off" class="form-control d-inline-block w-auto">
                                                </td>



                                            </tr>

                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @php
                        $redirect_url = route('ipd.pre-anesthetic-checkup-form', $pat_info->admission_no_pk);
                    @endphp
                    <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#doctor_name', 'hdn_doctor_id', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#Anesthetist_name', 'Anesthetist_no_fk', 'doctor_ind', '1,2');



    openDoctorAutocomplete('#assistant_surgeon_name', 'assistant_surgeon_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_2_surgeon_name', 'assistant_2_surgeon_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_3_surgeon_name', 'assistant_3_surgeon_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_4_surgeon_name', 'assistant_4_surgeon_no_fk', 'doctor_ind', '1,2');

    openDoctorAutocomplete('#anesthesiologist_name', 'anesthesiologist_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_anesthesiologist_name', 'assistant_anesthesiologist_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_2_anesthesiologist_name', 'assistant_2_anesthesiologist_no_fk', 'doctor_ind',
        '1,2');

    openDoctorAutocomplete('#scrub_nurse', 'scrub_nurse_no_fk');

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            // endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
        $('.timepicker').timepicker({
            // showInputs: false,
            // showMeridian: false,
            // setTime: null

        });

    });
    var editor2 = CKEDITOR.replace('editor2', {
        tabSpaces: 4
    });
    editor2.on('change', function(evt) {
        $('#editor_content2').val(evt.editor.getData())
    });
    var editor = CKEDITOR.replace('editor1', {
        tabSpaces: 4
    });

    editor.on('change', function(evt) {
        $('#editor_content').val(evt.editor.getData())
    });
</script>
