<?		
//Script laden zodat je nooit pagina buiten de index om kan laden
include("includes/security.php");

//Admin controle
if($gebruiker['admin'] < 3){
  header('location: index.php?page=home');
}

if(isset($_POST['change'])){
    mysql_query("INSERT INTO nieuws (titel_nl,text_nl,datum)
            VALUES ('".$_POST['titel']."','".$_POST['nl']."',NOW())");
	/*mysql_query("UPDATE nieuws SET text_en = '".$_POST['en']."', text_de = '".$_POST['de']."', text_es = '".$_POST['es']."', text_nl = '".$_POST['nl']."', text_pl = '".$_POST['pl']."'");
	*/
	echo '<div class="green"><img src="images/icons/green.png" width="16" height="16" /> Succesvol nieuwspagina bewerkt!</div>';
}

?>

<link href="includes/summernote/bootstrap.css" rel="stylesheet">
<link href="includes/summernote/summernote.css" rel="stylesheet">
<script>
$(document).ready(function() {
    $('#summernote').summernote({
        theme: 'yeti',
        lang: "nl-NL",
        callbacks : {
        onImageUpload: function(image) {
            uploadImage(image[0]);
        }
    },
        toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video', 'hr']],
        ['view', ['fullscreen']]
      ]
    });
    function uploadImage(image) {
    var data = new FormData();
    data.append("image",image);
    $.ajax ({
        data: data,
        type: "POST",
        url: "upload-image.php",
        cache: false,
        contentType: false,
        processData: false,
        success: function(url) {
           /* $('.summernote').summernote('insertImage', url);*/
            $('#summernote').summernote('insertImage', url, function ($image) {
              $image.css('width', $image.width() / 3);
              $image.attr('data-filename', 'retriever');
            });
			//console.log(url);
            },
            error: function(data) {
                console.log(data);
                }
        });
    }
});
</script>

<form method="post">

<strong>Titel</strong>
<br/>
<center>
<input type="text" id="titel" name="titel" class="text_long" style="float:none; width:86%;background-color: white!important;border: 0px;" maxlength="200">
</center>
<br/>
<br/>
<strong>Bericht</strong>
<div style="padding: 6px 0px 6px 0px;" align="center">
	<table width="600" cellpadding="0" cellspacing="0">
    	<tr>
            <td><textarea style="width:100%;" id="summernote" rows="15" name="nl"></textarea></td>
        </tr>
        	<td><div style="padding-top:10px;"><input type="submit" name="change" value="Wijzigen" class="button" /></div></td>
        </tr>
    </table> 
</div>        

</form>
