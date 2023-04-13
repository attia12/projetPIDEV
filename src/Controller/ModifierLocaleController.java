/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controller;

import Entity.Local;
import Services.ServiceLocal;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.TextField;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class ModifierLocaleController implements Initializable {

    @FXML
    private TextField nom_bloc;
    @FXML
    private TextField nom_patient;
    @FXML
    private TextField nom_medecin;
    @FXML
    private TextField localisation;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void modifier_locale(ActionEvent event) throws IOException {
        
        Local b = new Local(nom_bloc.getText(),nom_patient.getText(),nom_medecin.getText(),localisation.getText());
    ServiceLocal sb = new ServiceLocal();
    sb.modifier(b);
    
     FXMLLoader loader = new FXMLLoader(getClass().getResource("Afficherlocale.fxml"));
        Parent root = loader.load();
        localisation.getScene().setRoot(root);
        
      AfficherLocaleController dpc = loader.getController();
        
  
        dpc.setLbnom_bloc(b.getNom_block());
        dpc.setLbnom_patient(b.getNom_patient());
        dpc.setLbnom_medecin(b.getNom_medecin());
        dpc.setLblocalisation(b.getLocalisation());
      
       
    }

    @FXML
    private void quit(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("ChoixLocale.fxml"));
        Parent root = loader.load();
        localisation.getScene().setRoot(root);
    }
    
}
