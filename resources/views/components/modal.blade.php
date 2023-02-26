<div >
  <button class="btn btn-{{$type}}" type="button" data-bs-toggle="modal" data-bs-target="#{{$target}}">{{$buttonMessage}}</button>

<div class="modal fade" id="{{$target}}" aria-labelledby="delete" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="delete">{{$title}}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{$body}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit"class="btn btn-{{$type}}">{{$buttonMessage}}</button>
      </div>
    </div>
  </div>
</div>
</div>
