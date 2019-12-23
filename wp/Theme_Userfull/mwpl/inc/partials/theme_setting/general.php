<table class="form-table">
    <tr>
            <th><label for="mwpl_intro">Address</label></th>
            <td>
                    <textarea id="mwpl_intro" name="mwpl_address" cols="60" rows="5" ><?php echo esc_html( stripslashes( $settings["mwpl_address"] ) ); ?></textarea><br/>
                    
            </td>
    </tr>
    <tr>
        <th><label for="mwpl_phone">Phone Number</label></th>
            <td>
                <input type='text' name="mwpl_phone" value="<?php echo esc_html( stripslashes( $settings["mwpl_phone"] ) ); ?>">

            </td>
    </tr>
    <tr>
        <th><label for="mwpl_phone_whatsapp">Whats'App Number</label></th>
            <td>
                <input type='text' name="mwpl_phone_whatsapp" value="<?php echo esc_html( stripslashes( $settings["mwpl_phone_whatsapp"] ) ); ?>">

            </td>
    </tr>
</table>
                          