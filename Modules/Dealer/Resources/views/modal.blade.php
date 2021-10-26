<div class="modal fade" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">

      <!-- Modal Content -->
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-primary">
          <h3 class="modal-title text-white" id="model-1"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close text-white"></i>
          </button>
        </div>
        <!-- /modal header -->
        <form id="store_or_update_form" method="post" enctype="multipart/form-data">
          @csrf
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <input type="hidden" name="update_id" id="update_id"/>
                            <x-form.textbox labelName="Dealer Name" name="name" required="required" col="col-md-6" placeholder="Enter name"/>
                            <x-form.textbox labelName="Mobile No." name="mobile_no" required="required" col="col-md-6" placeholder="Enter mobile number"/>
                            <x-form.textbox labelName="Email" name="email" col="col-md-6" placeholder="Enter email"/>
                            <x-form.textbox labelName="Commission Rate(%)" name="commission_rate" col="col-md-6" placeholder="Enter commission rate"/>
                            <x-form.textbox labelName="Previous Balance" name="previous_balance" col="col-md-6 pbalance d-none" class="text-right" placeholder="Previous balalnce"/>
                            <x-form.selectbox labelName="Dealer Type" required="required" name="type" col="col-md-6" onchange="dealerType(this.value)" class="selectpicker">
                                <option value="1">Depo Dealer</option>
                                <option value="2">Direct Dealer</option>
                            </x-form.selectbox>
                            <x-form.selectbox labelName="Depo" name="depo_id" required="required" col="col-md-6 depo d-none" class="selectpicker" onchange="setDistrictData();getUpazilaList(2);">
                                @if (!$depos->isEmpty())
                                @foreach ($depos as $depo)
                                    <option value="{{ $depo->id }}">{{ $depo->name.' - '.$depo->mobile_no }}</option>
                                @endforeach
                                @endif
                            </x-form.selectbox>
                            <x-form.selectbox labelName="District" required="required" name="district_id" col="col-md-6" class="selectpicker" onchange="getUpazilaList(this.value,2)">
                                @if (!$districts->isEmpty())
                                    @foreach ($districts as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                @endif
                            </x-form.selectbox>
                            <x-form.selectbox labelName="Upazila" required="required" name="upazila_id" col="col-md-6" class="selectpicker" onchange="upazilaAreaList(this.value)"/>
                            <div class="form-group col-md-6 required">
                                <label for="area_id">Area</label>
                                <select name="areas[]" id="areas" class="form-control selectpicker" multiple data-selected-text-format="count > 3" data-live-search="true" 
                                data-live-search-placeholder="Search">
                                    <option value="">Select Please</option>
                                </select>
                            </div>
                            <x-form.textarea labelName="Address" name="address" col="col-md-6" placeholder="Enter address"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group col-md-12 mb-0 text-center">
                            <label for="logo" class="form-control-label">Dealer Photo</label>
                            <div class="col=md-12 px-0  text-center">
                                <div id="avatar">
                
                                </div>
                            </div>
                            <div class="text-center"><span class="text-muted">Maximum Allowed File Size 2MB and Format (png,jpg,jpeg,svg,webp)</span></div>
                            <input type="hidden" name="old_avatar" id="old_avatar">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /modal body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-sm" id="save-btn"></button>
            </div>
            <!-- /modal footer -->
        </form>
      </div>
      <!-- /modal content -->

    </div>
  </div>