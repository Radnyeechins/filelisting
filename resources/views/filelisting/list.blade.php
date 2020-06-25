<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>File Listing </title>
 
        <!-- Styles -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> 
         
        <!-- Script -->
         
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
          <div class="container">   
            <h2>List of all Files   </h2>

            <div class="row">
            <div class="col-lg-3">
                <form action="{{ url('search')  }}" method="POST" role="search">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" name="q"
                            placeholder="Search users"> <span class="input-group-btn">
                            <button type="submit" class="btn btn-default btn-info">
                                 search
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-lg-3">
                 <form action="{{ url('upload')  }}" method="POST"  enctype="multipart/form-data"> 
                    {{ csrf_field() }}

                    <div class="custom-file mb-2"> 
                    <input type="file" class="custom-file-input" accept="image/*,.doc, .docx,.txt,.pdf" id="customFile" name="file" required>
                      <label class="custom-file-label" for="customFile">Choose file to upload</label>

                    </div>
                    <button type="submit" class="btn btn-default btn-info"> upload </button>

                  </form>
            </div>

            </div>
            
        <br>
            <table class="table table-bordered table-striped datatable" id="table-2">
                <thead>
                    <tr>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($files as $file)
                    <tr>
                        <td>{{ $file->getFilename() }}</td>
                        <td>
                            <a href="javascript:void(0)" data-refer="{{ $file->getFilename() }}" class=" delete btn btn-red btn-sm btn-icon icon-left"><i class="entypo-cancel"></i>Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
             {{ $files->render() }}
            </div>
        </div>
        <script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

jQuery(document).ready(function($) {
             $(document).on("click", ".delete", function() { 
                
                var id= $(this).data('refer');
                var url = "{{url('delete')}}";
                var dltUrl = url;
                $.ajax({
                    url: dltUrl,
                    type: "post",
                    cache: false,
                    data:{
                        _token:'{{ csrf_token() }}',
                        id:id
                    },
                    success: function(dataResult){
                       location.reload();
                    }
                });
            });
});
</script>
    </body>
</html>
