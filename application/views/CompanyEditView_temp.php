<div class="tab-pane active" id="clone" >
    <div class="x_content">
        <div class="col-sm-3">
            <ul class="nav nav-tabs tabs-left">
                <li class="active">
                    <a class="categories1" href="#categories" data-toggle="tab">Categories</a>
                </li>
                <li>
                    <a class="cities1" href="#cities" data-toggle="tab">cities</a>
                </li>
            </ul>
        </div>
        <div class="col-sm-9">
            <div class="tab-content">
                <div class="tab-pane active" id="categories">
                    hjhhhjhdf
                    gfgfgfgfh
                    gfghhghg
                    
                </div> 
                <div class="tab-pane" id="cities">
                    <h2>Move Items From One List to Another</h2>
                    <select id="sbOne" multiple="multiple">
                        <option value="1">Alpha</option>
                        <option value="2">Beta</option>
                        <option value="3">Gamma</option>
                        <option value="4">Delta</option>
                        <option value="5">Epsilon</option>
                    </select>

                    <select id="sbTwo" multiple="multiple">
                        <option value="6">Zeta</option>
                        <option value="7">Eta</option>
                    </select>

                    <br />

                    <input type="button" id="left" value="<" />
                    <input type="button" id="right" value=">" />
                    <input type="button" id="leftall" value="<<" />
                    <input type="button" id="rightall" value=">>" />
                </div> 

            </div> 
        </div>

    </div> 
</div>





        <script>


            $(function () {
                function moveItems(origin, dest) {
                    alert(origin+"--"+dest);
                    alert($(origin).find(':selected'));
                    $(origin).find(':selected').appendTo(dest);
                }

                function moveAllItems(origin, dest) {
                    $(origin).children().appendTo(dest);
                }

                $('#left').click(function () {
                    moveItems('#sbTwo', '#sbOne');
                });

                $('#right').on('click', function () {
                    moveItems('#sbOne', '#sbTwo');
                });

                $('#leftall').on('click', function () {
                    moveAllItems('#sbTwo', '#sbOne');
                });

                $('#rightall').on('click', function () {
                    moveAllItems('#sbOne', '#sbTwo');
                });
            });
        </script>