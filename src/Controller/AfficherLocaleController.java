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
import javafx.scene.control.Label;
import javafx.scene.control.TextField;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class AfficherLocaleController implements Initializable {

    private Label localisation;
    @FXML
    private Label lbnom_bloc;
    @FXML
    private Label lbnom_patient;
    @FXML
    private Label lbnom_medecin;
    @FXML
    private Label lblocalisation;
    @FXML
    private Label aa;
    @FXML
    private TextField tfautre;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

 public void setLblocalisation(String a) {
        this.lblocalisation.setText(a);
    }
 public void setLbnom_bloc(String a) {
        this.lbnom_bloc.setText(a);
    }
 public void setLbnom_patient(String a) {
        this.lbnom_patient.setText(a);
    }
 
  public void setLbnom_medecin(String a) {
        this.lbnom_medecin.setText(a);
    }
 
 
    @FXML
    private void afficher(ActionEvent event) {
ServiceLocal ab = new ServiceLocal();
Local b =ab.rechercher(tfautre.getText());

        setLbnom_bloc(b.getNom_block());
        setLbnom_patient(b.getNom_patient());
        setLbnom_medecin(b.getNom_medecin());
        setLblocalisation(b.getLocalisation());

    
}

    @FXML
    private void supprimer_locale(ActionEvent event) {
        
     
ServiceLocal ab = new ServiceLocal();
ab.supprimer(lbnom_bloc.getText());
setLblocalisation("supprimé");
        setLbnom_bloc("supprimé");
       setLbnom_patient("supprimé");
        setLbnom_medecin("supprimé");
    

    }

     @FXML
    private void quit(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("ChoixLocale.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
    }
    
}
