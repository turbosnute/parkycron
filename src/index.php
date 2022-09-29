<?php
    $site = 'home';
    include("top.php");
?>
        
        <section>
            <div id="authform">
                <form>
                    <header>
                        <h2>Authentication</h2>
                    </header>

                        <label for="inputPhone">Phone number:</label>
                        <input type="text" id="inputPhone" name="inputPhone" size="14" placeholder="+47 000 00 000">
                        <button id="btnGetCode" type="button" onclick="getCode()">Get SMS Code</button>
                </form>
            </div>
        </section>

<?php
    include("bottom.php");
?>