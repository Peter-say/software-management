   <!-- Modal Structure -->
   <div class="modal fade" id="viewNotesModal-{{$purchase_history->id}}" tabindex="-1" aria-labelledby="viewNotesModalLabel-{{$purchase_history->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewNotesModalLabel">Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Notes Content -->
               @if ($purchase_history->notes)
               <p id="noteContent">{{$purchase_history->notes}}</p>
               @else
                   <div class="d-flex justify-content-center">
                    <p>No notes</p>
                   </div>
               @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>