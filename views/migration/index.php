<h2>Data Migration</h2>
<form name="uploader-frm" method="post" enctype="multipart/form-data">
  <label>Upload DB File</label>
  <input type="file" name="uploader-file" />
  <input type="submit" value="Upload File" name="uploader-button" />
</form>

<style>
  body {background: #f9f9f9; font-family: 'segoe ui', arial;}
  h2 {border-bottom: 1px #ddd solid; margin-bottom: 10px; padding-bottom: 20px; font-size: 20px; color: #ea0832;}
  code {line-height: 20px; background: #fff; padding: 20px; display: block; border: 1px #d8d8d8 dashed;}
  code strong {color: #f70755;}
  form {background: #f7f7f7; margin: 10px 0px; padding: 10px; border: 1px #cdcdcd dashed; font-size: 12px;}
</style>

<code>
    <?php
    if(isset($stepDetails)) {
        echo '<ul>';
            foreach($stepDetails as $step) {
                echo '<li>' . $step . '</li>';
            }
        echo '</ul>';
    } else {
        echo 'Process output will be print here.';
    }
    ?>
</code>