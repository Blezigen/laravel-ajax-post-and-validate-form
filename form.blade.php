<!DOCTYPE html>
<html>
<head>
    <title>Laravel Ajax Validation Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
</head>
<body>


<div class="container">
    <h2>Laravel Ajax Validation</h2>

    <form>
        {{ csrf_field() }}
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" placeholder="First Name">
        </div>


        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control" placeholder="Last Name">
        </div>


        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" placeholder="Email">
        </div>


        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" name="address" placeholder="Address"></textarea>

        </div>


        <div class="form-group">
            <button class="btn btn-success btn-submit" data-action="{{ route("form-post") }}" data-method="POST">Submit</button>
        </div>
    </form>
</div>


<script type="text/javascript">


    $(document).ready(function() {

        function InputNormalStyle(inputs){
            $.each(inputs, function (k,v) {
                let field = $("[name='"+v+"']");
                field.parent().find("label[for='"+v+"']").toggleClass("is-invalid", false);
                field.toggleClass("is-invalid", false);
                field.parent().find(".alert").remove();
            });

        }

        function InputMergeData(parent, fields) {
            let data = {};

            $.each(fields, function (k,v) {
                data[v] = parent.find("[name='"+v+"']").val();
            });

            return data;
        }

        function InputErrorStyle(field, messages){
            let input = $("[name='"+field+"']");
            input.toggleClass("is-invalid", true);
            input.parent().find("label[for='"+field+"']").toggleClass("is-invalid", false);
            $.each(messages, function (k, message) {
                input.parent().append('<div class="alert alert-danger">'+message+'</div>');
            });
        }

        function Success(data){
            alert(data.success);
        }

        $(".btn-submit").click(function(e){
            e.preventDefault();

            let SEND_ACTION = "";
            let SEND_METHOD = "POST";

            if (typeof $(this).data('action') !== 'undefined') {
                SEND_ACTION = $(this).data('action');
            }
            if (typeof $(this).data('method') !== 'undefined') {
                SEND_METHOD = $(this).data('method');
            }

            let SEND_DATA = InputMergeData($("form"),["_token","first_name","last_name","email","address"]);

            $.ajax({
                url: SEND_ACTION,
                type: SEND_METHOD,
                data: SEND_DATA,

                beforeSend: function(){
                    InputNormalStyle(["first_name","last_name","email","address"]);
                },

                success: function(data) {
                    if($.isEmptyObject(data.error)) {
                        Success(data);
                    }
                    else {
                        $.each(data.error, function (k,v) {
                            InputErrorStyle(k, v)
                        });
                    }
                }
            });


        });
    });


</script>


</body>
</html>