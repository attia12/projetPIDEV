/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controller;

import Entity.Consultation;
import Entity.Local;
import Services.ServiceConsultation;
import Services.ServiceLocal;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class ModifierConsultationController implements Initializable {

    @FXML
    private TextField nom_patient;
    @FXML
    private TextField nom_medecin;
    @FXML
    private TextField date;
    @FXML
    private TextField duree;
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
    private void modifier_consultation(ActionEvent event) throws IOException {
        
        Consultation b = new Consultation(nom_patient.getText(),nom_medecin.getText(),date.getText(),duree.getText());
    ServiceConsultation sb = new ServiceConsultation();
    sb.modifier(b);
    
     FXMLLoader loader = new FXMLLoader(getClass().getResource("Afficherconsultation.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
      AfficherConsultationController dpc = loader.getController();
        
  
       
        dpc.setLbnom_patient(b.getNom_patient());
        dpc.setLbnom_medecin(b.getNom_medecin());
         dpc.setLbdate(b.getDate());
        dpc.setLbduree(b.getDuree());

        
       
    }

     @FXML
    private void quit(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("ChoixConsultation.fxml"));
        Parent root = loader.load();
        date.getScene().setRoot(root);
    }
}
