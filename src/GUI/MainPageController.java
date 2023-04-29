/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import com.jfoenix.controls.JFXButton;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.image.Image;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.Pane;
import javafx.scene.layout.StackPane;
import javafx.scene.paint.ImagePattern;
import javafx.scene.shape.Rectangle;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class MainPageController implements Initializable {

    @FXML
    private HBox root;
    @FXML
    private AnchorPane side_ankerpane;
    @FXML
    private Pane inner_pane;
    @FXML
    private JFXButton btn_workbench1;
    @FXML
    private JFXButton btn_workbench11;
    @FXML
    private Rectangle Userlogo;
    @FXML
    private StackPane contentArea;
    @FXML
    private JFXButton btn_workbench111;
    @FXML
    private JFXButton btn_workbench12;
    @FXML
    private Pane inner_pane1;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
                     }    

    private void page1(ActionEvent event) throws IOException {

    }

    @FXML
    private void AddLocal(ActionEvent event) throws IOException {
                        Parent fxml = FXMLLoader.load(getClass().getResource("FxLocal.fxml"));
        contentArea.getChildren().removeAll();
        contentArea.getChildren().setAll(fxml);
    }

    @FXML
    private void AddCon(ActionEvent event) throws IOException {
                                Parent fxml = FXMLLoader.load(getClass().getResource("AjouterConsultation.fxml"));
        contentArea.getChildren().removeAll();
        contentArea.getChildren().setAll(fxml);
    }

    @FXML
    private void ViewCon(ActionEvent event) {
    }

    @FXML
    private void ViewLocal(ActionEvent event) throws IOException {
                                Parent fxml = FXMLLoader.load(getClass().getResource("ViewLocal.fxml"));
        contentArea.getChildren().removeAll();
        contentArea.getChildren().setAll(fxml);
    }
    
}
