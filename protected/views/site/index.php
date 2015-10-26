<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>


<div class="categories">


    <div>
        <a>Rock</a>
        <select>
            <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
        </select>

    </div>
    <div>
        <a>Rock</a>
        <select>
            <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
        </select>

    </div>
    <div>
        <a>Blues</a>
        <select>
            <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
        </select>

    </div>
    <div>
        <a>pop</a>
        <select>
            <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
        </select>

    </div>
    <div>
        <a>jaz</a>
        <select>
            <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
        </select>
        <div class="playCategorie"><a>Play Categories</a></div>
    </div>


</div>
<div class="savemp3">
    <div><a></a></div>
</div>

<div class="playlist">
    <div class="mp3"></div>
    <div class="play">
        <audio id="audio-element"
               src="mp3/a.mp3"
               controls="true"
               style="width: 400px;">
        </audio>
        <div class="next">

            <form name="audio_form" id="audio_form" action="add" method="post" enctype="multipart/form-data">
                <fieldset>
                    <label>Audio File:</label>
                    <input name="audio_file" id="audio_file" type="file"/>
                    <input type="submit" name="Submit" id="Submit" value="upload MP3"/>
                </fieldset>
            </form>

        </div>
        <div class="mp3songs">

        </div>
    </div>
    <input type="submit" id="next" value="Next"></a>

</div>

<div class="creatId">
    <div>
        <table width="600">
            <form action="site/file" method="post" enctype="multipart/form-data">

                <tr>
                    <td width="20%">Select file</td>
                    <td width="80%"><input type="file" name="file" id="file" /></td>
                </tr>

                <tr>
                    <td>Submit</td>
                    <td><input type="submit" name="submit" /></td>
                </tr>

            </form>
        </table>

    </div>
  

</div>
