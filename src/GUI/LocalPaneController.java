/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entity.Local;
import api.Weather;
import com.jfoenix.controls.JFXButton;
import java.io.IOException;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import javafx.stage.Stage;
import javafx.stage.StageStyle;
import org.json.simple.JSONObject;


/**
 * FXML Controller class
 *
 * @author donia
 */
public class LocalPaneController implements Initializable {

    @FXML
    private ImageView bkimg;
    @FXML
    private Label temp;
    @FXML
    private ImageView weather;
    @FXML
    private Label BlocName;
    @FXML
    private Label PatientName;
    @FXML
    private Label cname;
    @FXML
    private Label Loca;
        Weather weath = new Weather();


    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    public void setData(Local pv) throws MalformedURLException {
        Image img = new Image(pv.getImage());
        bkimg.setImage(img);
        PatientName.setText(pv.getNom_patient());
        cname.setText(pv.getNom_medecin());
        Loca.setText(String.valueOf(pv.getLocalisation()));
        JSONObject weatherobj = weath.GetTwi(pv.getLocalisation());
        System.out.println(" talking about weather in genral  " + weatherobj);
        JSONObject tempeture = (JSONObject) weatherobj.get("current");
        temp.setText(String.valueOf(tempeture.get("temp_c")) + "°C");
        JSONObject condition = (JSONObject) tempeture.get("condition");
        System.out.println(" talking about tempture  " + tempeture.get("temp_c"));

        String lin = "ressources/" + weath.searchMe((String) condition.get("icon"));
        System.out.println(lin);
        Image wimg = new Image(lin);

        weather.setImage(wimg);


    
}}
