/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controller;

import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Label;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class BienvenueController implements Initializable {

    @FXML
    private Label aa;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void consultation(ActionEvent event) throws IOException {
         FXMLLoader loader = new FXMLLoader(getClass().getResource("ChoixConsultation.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
       ChoixConsultationController dpc = loader.getController();
        
    }

    @FXML
    private void locale(ActionEvent event) throws IOException {
         FXMLLoader loader = new FXMLLoader(getClass().getResource("ChoixLocale.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
       ChoixLocaleController dpc = loader.getController();
        
    }

    
}
