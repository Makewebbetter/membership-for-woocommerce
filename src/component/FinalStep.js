import React,{useContext,Fragment} from 'react';
import Context from '../store/store';
import {Radio,RadioGroup, FormControlLabel, FormControl, FormLabel, TextField, Button } from '@material-ui/core';
import { makeStyles } from '@material-ui/core/styles';
import { __ } from '@wordpress/i18n';
const useStyles = makeStyles({
      margin: {
        marginBottom: '20px',
      },
});
export default function FinalStep(props) {
    const classes = useStyles();
    const ctx = useContext(Context)
    return (
        <Fragment>
            <FormControl component="fieldset" fullWidth className="fieldsetWrapper">
            <FormLabel component="legend" className="mwbFormLabel">{ __('Bingo! You are all set to take advantage of your business. Lastly, we urge you to allow us collect some','subscriptions-for-woocommerce')} <a href='https://makewebbetter.com/plugin-usage-tracking/' target="_blank" >{__('information','subscriptions-for-woocommerce') }</a> { __( 'in order to improve this plugin and provide better support. If you want, you can dis-allow anytime settings, We never track down your personal data. Promise!', 'membership-for-woocommerce' ) }
                </FormLabel>
                <RadioGroup aria-label="gender" name="consetCheck" value={ctx.formFields['consetCheck']} onChange={ctx.changeHandler} className={classes.margin}>
                    <FormControlLabel value="yes" control={<Radio color="primary"/>} label="Yes" className="mwbFormRadio"/>
                    <FormControlLabel value="no" control={<Radio color="primary"/>} label="No" className="mwbFormRadio"/>
                </RadioGroup>
            </FormControl>
            <FormControl component="fieldset" fullWidth className="fieldsetWrapper">
            {(() => {
     
                if (frontend_ajax_object.is_pro_plugin == 'true') {
                     return (
                      <TextField 
                        value={ctx.formFields['licenseCode']}
                        onChange={ctx.changeHandler} 
                        id="licenseCode" 
                        name="licenseCode" 
                        label={__('Enter your license code')}  variant="outlined" className={classes.margin}/>

                        )
                }
          })()}
          <div id="div_licence"></div>
              <Button id="button_licence" value="buttomn" fullWidth="100%" border="20%" theme="pink" color="black">{ __( 'Validate Licence Key', 'membership-for-woocommerce' ) }</Button>
                </FormControl>
        </Fragment> 
    );
}
