<div id="campaign-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog full-modal-dialog" role="document">
        <div class="modal-content full-modal-content">
            <div class="modal-body contract-modal-body">
                <form action="{{route('dashboard.ads.editContract',$data->id)}}">
                    <textarea id="contract-text" name="contract"></textarea>
                </form>
            </div>
            <div class="modal-footer border-0 py-1 justify-content-center">
                <button type="button" class="btn btn-secondary" onclick="updateContract(this)">Update</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="unchosen_inf" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog full-modal-dialog" role="document">
        <div class="modal-content full-modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Replace Influencer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="accept_ad_contract" class="modal accept_adcontract_modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body accept_ad_contract_body">
                <p>Please provide the ad link</p>
                <input type="text" id="link_ad_contract_input" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="sendAdContractStatus()" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>
</div>

<div id="influencer-data" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Influencer Campaign data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Scenario</label>
                    <textarea class="form-control" name="content" id="scenario" rows="10" cols="80"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Date</label>
                    <input id="contractDate" value="" name="influencer_date" type="date" class="form-control"
                        id="inputAddress2" placeholder="date">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary text-center align-middle" onclick="saveInfluencerData(this)">Save</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="reject_ad_contract" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Add Reject Reason</p>
                <textarea id="reject_ad_contract_input" class="form-control" id="rejectedNote" rows="12"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="sendAdContractStatus('reject')"
                    class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>
</div>


<div id="rejectedReson" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejected Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="rejectedNote" rows="12"></textarea>
            </div>
            <div class="modal-footer">
                <button onclick="sendUpdateNoteRequest(this,true,'rejectedNote')" type="button" class="btn btn-primary">Send</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>