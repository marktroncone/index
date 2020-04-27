<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Linetime</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <link rel="manifest" href="public/site.webmanifest">
        <link rel="apple-touch-icon" href="public/icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="public/css/main.css">
    </head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->
        <div class="app_container">
            <div class="sidebar">
                <button id="menu_button"><img src="public/img/menu.png"/></button>
                <div class="sortby">
                    <span>Latest Updates</span>
 <!--                   <select>
                    <option value="short">Shortest Time</option>
                    <option value="long">Longest Time</option>
                    </select> -->
                </div>
                <div class="listings" id="listings"></div>
            </div>
            <div class="controls" style="position: absolute;top:11px;right: 0;z-index: 12;">
                <button id="mylocationbutton" title="Your Location">
                    <div id="my_location_marker" style="background-position: 0px 0px;"></div>
                </button>
                <button id="addVenueButton" class="addVenueButton" title="Add New Venue">
                    <div id="add_venue_image"></div>
                </button>
            </div>
            <!-- The Modal -->
            <div id="addVenueModal" class="modal">
              <!-- Modal content -->
              <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <h2>ADD VENUE</h2>
                    <div class="modal_inputs">
                        <form name="submit_venue" id="submit_venue" method="post" action="get" enctype="multipart/form-data">
                            <input name="newVenue[venue_name]" id="venue_name" class="modal-textInput" placeholder="VENUE NAME"/>
                            <input name="newVenue[venue_address]" id="venue_address" class="modal-textInput" placeholder="VENUE ADDRESS"/>
                            <div class="venu_logo">
                                <span>VENUE LOGO</span>
                                <p>(Upload)</p>
                            </div>
                            <div class="place_types">
                                <div class="place_type add_place_type selected">
                                    <img src="public/img/dj.png" class="place_typeImg" />
                                    <p>NIGHTCLUB</p>
                                </div>
                                <div class="place_type add_place_type">
                                    <img src="public/img/bar.png" class="place_typeImg" />
                                    <p>BAR</p>
                                </div>
                            </div>
                            <input type="hidden" name="newVenue[latitude]" id="latitude" />
                            <input type="hidden" name="newVenue[longitude]" id="longitude" />
                            <input type="hidden" name="newVenue[place_type]" id="place_type" value="nightclub"/>
                        </form>
                        <form action="get/index.php" method="post" enctype="multipart/form-data" id="formFile">
                            <input type="file" id="logoFile" name="logoFile" data-preview="venu_logo">
                        </form>
                    </div>
                </div>
                <div class="buttons">
                    <button id="cancelButton" style="float:left;" onclick="return false;">CANCEL</button>
                    <button id="submitButton" style="float:right;">SAVE</button>
                    <div style="clear: both;"></div>
                </div>
              </div>
            </div>
            <div id="viewVenueModal" class="modal">
            <!-- Modal content -->
              <div class="modal-content">
                <div class="modal-header"></div>
                <div class="modal-body">
                    <span class="close">&times;</span>
                    <div class="venue_container">
                        <div class="venueInfo">
                            <div>                        
                                <h2 id="venueNameS"><span></span></h2>
                                <h4 id="venueAddressS">
                                    <address></address>
                                </h4>
                               <div class="place_type_current_bar">
                                    <img src="public/img/bar.png" class="place_typeImg" />
                                    <p>BAR</p>
                               </div>
                               <div class="place_type_current_nightclub" style="display: none;">
                                    <img src="public/img/dj.png" class="place_typeImg" />
                                    <p>NIGHTCLUB</p>
                               </div> 
                            </div>
                            <div class="venueLogo">
                                <img id="venueLogoImg">
                            </div>
                        </div>
                        <div class="venueTimeInfo">
                            <h6>VENUE QUEUE TIME</h6>
                            <h3>15 MIN</h3>
                            <p></p>
                        </div>
                    </div>
                    <div class="updateButtons">
                        <button id="editVenue">Edit Venue</button>
                        <button id="editQueue">Update Queue Time</button>
                        <div style="clear:right;"></div>
                    </div>
                </div>
              </div>
            </div>
            <div id="updateVenueModal" class="modal">
              <!-- Modal content -->
              <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <h2>EDIT VENUE</h2>
                    <div class="edit_buttons">
                        <button id="move_pin"></button>
                        <button id="remove_pin"></button>
                    </div>
                    <div class="modal_inputs" id="edit_venue_inputs">
                        <form name="submit_venue" id="submit_venue" method="post" action="get" enctype="multipart/form-data">
                            <input name="updateVenue[venue_name]" id="update_venue_name" class="modal-textInput" placeholder="CURRENT VENUE NAME"/>
                            <input name="updateVenue[venue_address]" id="update_venue_address" class="modal-textInput" placeholder="CURRENT VENUE ADDRESS"/>
                            <div class="update_venue_logo"></div>
                            <div class="place_types">
                                <div class="place_type place_type_update selected">
                                    <img src="public/img/dj.png" class="place_typeImg" />
                                    <p>NIGHTCLUB</p>
                                </div>
                                <div class="place_type place_type_update">
                                    <img src="public/img/bar.png" class="place_typeImg" />
                                    <p>BAR</p>
                                </div>
                            </div>
                            <input type="hidden" name="updateVenue[latitude]" id="update_latitude"/>
                            <input type="hidden" name="updateVenue[longitude]" id="update_longitude"/>
                            <input type="hidden" name="updateVenue[place_type]" id="place_type_update" value="nightclub"/>
                        </form>
                        <form action="get/index.php" method="post" enctype="multipart/form-data" id="formFile">
                            <input type="file" id="update_logoFile" name="update_logoFile" data-preview="update_venue_logo">
                        </form>
                    </div>
                    <div class="buttons">
                        <button id="cancelButton2" style="float:left;" onclick="return false;">CANCEL</button>
                        <button id="submitUpdate" style="float:right;">UPDATE</button>
                        <div style="clear: both;"></div>
                    </div>
                </div>
              </div>
            </div>
            <div id="updateQueueModal" class="modal">
              <!-- Modal content -->
              <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div class="venueInfo">
                        <div>                        
                            <h2 id="venueNameS"><span>Venue Name</span></h2>
                            <h4 id="venueAddressS">
                                <address></address>
                            </h4>
                        </div>
                        <div class="venueLogo">
                            <img id="venueLogoImg">
                        </div>
                    </div>
                    <div class="current_queue_time">
                        <h4>CURRENT VENUE QUEUE TIME</h4>
                        <h2>15 MIN</h2>
                        <h6>UPDATED 3 DAYS AGO</h6>
                    </div>
                    <h6 class="queue_time_title">UPDATE QUEUE TIME</h6>
                    <div class="modal_inputs">
                        <form name="submit_venue" id="submit_venue" method="post" action="get" enctype="multipart/form-data">
                            <div class="queue_time_form">
                                <input name="updateVenue[queue_time]" id="update_venue_queue" min="1" maxlength="4" type="text" class="modal-textInput" placeholder="UPDATE HERE" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
                                <div class="hr_min">
                                    <div id="queue_min" class="selected">MIN</div>
                                    <div id="queue_hr">HR</div>
                                </div>
                            </div>

                            <input type="hidden" name="updateVenue[hr_minType]" id="hr_minType" value="MIN"/>
                        </form>
                    </div>
                </div>
                  <div class="buttons">
                        <button id="cancelButton3" style="float:left;">CANCEL</button>
                        <button id="updateQueueTime" style="float:right;">UPDATE</button>
                        <div style="clear: both;"></div>
                  </div>
              </div>
            </div>
            <div class="prompt" id="move_pin_prompt">
                <h5>Do you want to Move Pin's Location?</h5>
                <div class="prompt-buttons">
                    <button id="movePinTrue">Yes</button>
                    <button id="movePinFalse">No</button>
                    <div style="clear:both;"></div>
                </div>
            </div>
            <div class="prompt" id="remove_venue_prompt">
                <h5>Please Enter Password</h5>
                <div class="password-input">
                    <input type="password" id="password" />
                </div>
                <div class="prompt-buttons">
                    <button id="cancelRemove">Cancel</button>
                    <button id="submitRemove">Remove</button>
                    <div style="clear:both;"></div>
                </div>
            </div>
            <div class="prompt_overlay"></div>
            <div class="instruction"><h6>Drag Marker</h6></div>
        </div>
        <div id="map"></div>
        <script src="public/js/plugins.js"></script>
        <script src="public/js/main3.js"></script>

        <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
        <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','UA-XXXXX-Y','auto');ga('send','pageview')
        </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBiF3SvQ28lTrs2Y6sV0wFE2Sk0UjwJ4FU&libraries=places&callback=initMap"></script>
            <script src="https://cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js"></script>
        <script src="https://www.google-analytics.com/analytics.js" async defer></script>
    </body>
</html>