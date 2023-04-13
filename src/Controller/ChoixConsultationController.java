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
public class ChoixConsultationController implements Initializable {

    @FXML
    private Label aa;
    @FXML
    private Label aa1;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void ajouter(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("AjouterConsultation.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
       AjouterConsultationController dpc = loader.getController();
    }
    

    private void modifier(ActionEvent event) throws IOException { 
        FXMLLoader loader = new FXMLLoader(getClass().getResource("ModifierConsultation.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
      ModifierConsultationController dpc = loader.getController();

    }

    @FXML
    private void afficher(ActionEvent event) throws IOException {
         FXMLLoader loader = new FXMLLoader(getClass().getResource("AfficherConsultation.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
       AfficherConsultationController dpc = loader.getController();

    }

    private void supprimer(ActionEvent event) throws IOException {
         FXMLLoader loader = new FXMLLoader(getClass().getResource("SupprimerConsultation.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
        
      SupprimerConsultationController dpc = loader.getController();

    }
    @FXML
      private void quit(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("Bienvenue.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
    }
    
}
