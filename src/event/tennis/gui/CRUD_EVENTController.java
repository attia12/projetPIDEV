/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package event.tennis.gui;

import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.ListView;
import javafx.scene.control.TextField;
import javafx.scene.layout.AnchorPane;
import javafx.scene.text.Text;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class CRUD_EVENTController implements Initializable {

    @FXML
    private AnchorPane lst;
    @FXML
    private TextField nom_block;
    @FXML
    private Text Nom;
    @FXML
    private TextField nom_patient;
    @FXML
    private TextField nom_medecin;
    @FXML
    private TextField localisation;
    @FXML
    private Button btnView;
    @FXML
    private Button btnADD;
    @FXML
    private Button btnDelete;
    @FXML
    private Button btnUpdate;
    @FXML
    private ListView<?> v_event;
    @FXML
    private TextField tRecherche;
    @FXML
    private Button rech;
    @FXML
    private Button dashBtn;
    @FXML
    private Button eventBtn;
    @FXML
    private Button PartBtn;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void afficherEvenement(ActionEvent event) {
    }

    @FXML
    private void ajouterEvenement(ActionEvent event) {
    }

    @FXML
    private void supprimerEvenement(ActionEvent event) {
    }

    @FXML
    private void modifierEvenement(ActionEvent event) {
    }

    @FXML
    private void recherche(ActionEvent event) {
    }

    @FXML
    private void dashboard(ActionEvent event) {
    }

    @FXML
    private void evenment(ActionEvent event) {
    }

    @FXML
    private void participation(ActionEvent event) {
    }
    
}
