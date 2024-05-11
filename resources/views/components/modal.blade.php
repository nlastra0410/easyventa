@props(['modalTitle'=>'','modalId'=>'','modalSize'=>''])
  <!-- Modal -->
  <div wire:ignore.self  class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog {{$modalSize}}">
      <div class="modal-content" style="border-radius: 24px">
        <div class="modal-header" style="background: linear-gradient(to right, #084d68, #def6ff); color:white; border-top-left-radius:20px; border-top-right-radius: 20px;">
          <h3 class="modal-title" id="exampleModalLabel">{{$modalTitle}}</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{$slot}}
        </div>
        <!--<div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>-->
      </div>
    </div>
  </div>
  