{include file="sections/header.tpl"}

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary panel-hovered panel-stacked mb30">
                <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{Lang::T('Edit Contact')}</span>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#tutorialModal" style="margin-left: auto;">
                        {Lang::T('Need Help?')}
                    </button>
                </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post" role="form" action="{$_url}customers/edit-post">
                    <input type="hidden" name="id" value="{$d['id']}">
                    <div class="form-group">
                        <label class="col-md-4 control-label">{Lang::T('Username')}</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                {if $_c['country_code_phone']!= ''}
                                <span class="input-group-addon" id="basic-addon1">+</span>
                                {else}
                                <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-phone-alt"></i></span>
                                {/if}
                                <input type="text" class="form-control" name="username" value="{$d['username']}" required placeholder="{if $_c['country_code_phone']!= ''}{$_c['country_code_phone']}{/if} {Lang::T('Phone Number')}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{Lang::T('Full Name')}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="fullname" name="fullname" value="{$d['fullname']}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{Lang::T('Email')}</label>
                        <div class="col-md-8">
                            <input type="email" class="form-control" id="email" name="email" value="{$d['email']}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{Lang::T('Phone Number')}</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                {if $_c['country_code_phone']!= ''}
                                <span class="input-group-addon" id="basic-addon1">+</span>
                                {else}
                                <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-phone-alt"></i></span>
                                {/if}
                                <input type="text" class="form-control" name="phonenumber" value="{$d['phonenumber']}" placeholder="{if $_c['country_code_phone']!= ''}{$_c['country_code_phone']}{/if} {Lang::T('Phone Number')}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{Lang::T('Address')}</label>
                        <div class="col-md-8">
                            <textarea name="address" id="address" class="form-control">{$d['address']}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{Lang::T('Coordinates')}</label>
                        <div class="col-md-8">
                            <input name="coordinates" id="coordinates" class="form-control" value="{$d['coordinates']}" placeholder="6.465422, 3.406448">
                            <div id="map" style="width: 100%; height: 200px; min-height: 150px;"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{Lang::T('Password')}</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" autocomplete="off" class="form-control" id="password" name="password" onmouseleave="this.type = 'password'" onmouseenter="this.type = 'text'" value="{$d['password']}">
                            </div>
                            <span class="help-block">{Lang::T('Keep Blank to do not change Password')}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{Lang::T('PPPOE Password')}</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" autocomplete="off" class="form-control" id="pppoe_password" name="pppoe_password" value="{$d['pppoe_password']}" onmouseleave="this.type = 'password'" onmouseenter="this.type = 'text'">
                            </div>
                            <span class="help-block">{Lang::T('User Cannot change this, only admin. if it Empty it will use user password')}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">IP Address</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="Enter IP Address" value="{$d['ip_address']}">
                        </div>
                    </div>
                                      <!-- SMS Group Selection -->
                    <div class="form-group">
                        <label class="col-md-4 control-label">{Lang::T('SMS Group')}</label>
                        <div class="col-md-8">
                            <select class="form-control" id="sms_group_id" name="sms_group_id">
                                <option value="">{Lang::T('Select SMS Group (optional)')}</option>
                                {foreach from=$sms_groups item=group}
                                <option value="{$group.id}">{$group.group_name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{Lang::T('Service Type')}</label>
                        <div class="col-md-8">
                            <select class="form-control" id="service_type" name="service_type">
                                <option value="Hotspot" {if $d['service_type'] eq 'Hotspot'}selected{/if}>Hotspot</option>
                                <option value="PPPoE" {if $d['service_type'] eq 'PPPoE'}selected{/if}>PPPoE</option>
                                <option value="Static" {if $d['service_type'] eq 'Static'}selected{/if}>Static</option>
                                <option value="Others" {if $d['service_type'] eq 'Others'}selected{/if}>Others</option>
                            </select>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">Router</label>
                        <div class="col-md-8">
                            <select class="form-control" id="router_id" name="router_id">
                                <option value="">Select Router (optional)</option>
                                {foreach from=$routers item=router}
                                <option value="{$router.id}" {if $router.id eq $d['router_id']}selected{/if}>{$router.name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-primary panel-hovered panel-stacked mb30">
            <div class="panel-heading">{Lang::T('Attributes')}</div>
            <div class="panel-body">
                <!--Customers Attributes edit start -->
                {if $customFields}
                    {foreach $customFields as $customField}
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="{$customField.field_name}">{$customField.field_name}</label>
                            <div class="col-md-6">
                                <input class="form-control" type="text" name="custom_fields[{$customField.field_name}]" id="{$customField.field_name}" value="{$customField.field_value}">
                            </div>
                            <label class="col-md-2">
                                <input type="checkbox" name="delete_custom_fields[]" value="{$customField.field_name}"> Delete
                            </label>
                        </div>
                    {/foreach}
                {/if}
                <!--Customers Attributes edit end -->
                <!-- Customers Attributes add start -->
                <div id="custom-fields-container">
                </div>
                <!-- Customers Attributes add end -->
            </div>
            <div class="panel-footer">
                <button class="btn btn-success btn-block" type="button" id="add-custom-field">{Lang::T('Add')}</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 text-center">
        <button class="btn btn-primary" type="submit">{Lang::T('Save Changes')}</button>
        Or <a href="{$_url}customers/list">{Lang::T('Cancel')}</a>
    </div>
</div>

</form>

{literal}
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        var customFieldsContainer = document.getElementById('custom-fields-container');
        var addCustomFieldButton = document.getElementById('add-custom-field');
        addCustomFieldButton.addEventListener('click', function () {
            var fieldIndex = customFieldsContainer.children.length;
            var newField = document.createElement('div');
            newField.className = 'form-group';
            newField.innerHTML = `
                <label class="col-md-4 control-label">Name:</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="custom_field_name[]" placeholder="Name">
                </div>
                <label class="col-md-4 control-label">Value:</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="custom_field_value[]" placeholder="Value">
                </div>
                <div class="col-md-2">
                    <button type="button" class="remove-custom-field btn btn-danger btn-sm">-</button>
                </div>
            `;
            customFieldsContainer.appendChild(newField);
        });

        customFieldsContainer.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-custom-field')) {
                var fieldContainer = event.target.parentNode.parentNode;
                fieldContainer.parentNode.removeChild(fieldContainer);
            }
        });
    });

    function getLocation() {
        if (window.location.protocol == "https:" && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            setupMap(51.505, -0.09);
        }
    }

    function showPosition(position) {
        setupMap(position.coords.latitude, position.coords.longitude);
    }

    function setupMap(lat, lon) {
        var map = L.map('map').setView([lat, lon], 13);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/light_all/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);
        var marker = L.marker([lat, lon]).addTo(map);
        map.on('click', function(e) {
            var coord = e.latlng;
            var lat = coord.lat;
            var lng = coord.lng;
            var newLatLng = new L.LatLng(lat, lng);
            marker.setLatLng(newLatLng);
            $('#coordinates').val(lat + ',' + lng);
        });
    }

    window.onload = function() {
        {/literal}{if $d['coordinates']}
            var coordinates = "{$d['coordinates']}".split(",");
            var lat = parseFloat(coordinates[0]);
            var lon = parseFloat(coordinates[1]);
            setupMap(lat, lon);
        {else}
            getLocation();
        {/if}{literal}
    }
</script>
{/literal}

<div class="modal fade" id="tutorialModal" tabindex="-1" role="dialog" aria-labelledby="tutorialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tutorialModalLabel">Tutorial Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/e00RsnZZ5wE?si=SMGZr8eDKZgHojCG" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


{include file="sections/footer.tpl"}