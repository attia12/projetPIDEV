/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controller;

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

/**
 * FXML Controller class
 *
 * @author donia
 */
public class AfficherConsultationController implements Initializable {
    @FXML
    private Label aa;
    @FXML
    private Label lbnom_patient;
    @FXML
    private Label lbnom_medecin;
    @FXML
    private Label lbdate;
    @FXML
    private Label lbduree;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    
public void setLbdate(String a) {
        this.lbdate.setText(a);
    }
 public void setLbduree(String a) {
        this.lbduree.setText(a);
    }
 public void setLbnom_patient(String a) {
        this.lbnom_patient.setText(a);
    }
 
  public void setLbnom_medecin(String a) {
        this.lbnom_medecin.setText(a);
    }
 
    @FXML
    private void modifier(ActionEvent event) {
    }

     @FXML
    private void supprimer_Cons(ActionEvent event) {
ServiceConsultation ab = new ServiceConsultation();
ab.supprimer(lbnom_patient.getText());
setLbnom_patient("supprimé");
        setLbnom_medecin("supprimé");
       setLbdate("supprimé");
        setLbduree("supprimé");
    }

         @FXML
    private void quit(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("ChoixConsultation.fxml"));
        Parent root = loader.load();
        aa.getScene().setRoot(root);
    }

    @FXML
    private void autre(ActionEvent event) {
    }
    }
    


