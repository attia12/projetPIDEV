/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entity.Local;
import Services.ServiceLocal;
import com.jfoenix.controls.JFXTextField;
import java.io.IOException;
import java.net.URL;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.geometry.Insets;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.Pane;
import javafx.scene.paint.ImagePattern;
import javafx.stage.Stage;
import javafx.stage.StageStyle;
import javax.swing.JOptionPane;
import ressources.Util;

/**
 * FXML Controller class
 *
 * @author donia
 */
public class ViewLocalController implements Initializable {
    private List<Local> list;
        private List<Local> filterdlist;

    ServiceLocal sp = new ServiceLocal();

    @FXML
    private Label nbPst;
    @FXML
    private GridPane PlacesGrid;
    @FXML
    private JFXTextField SearchByMe;
    @FXML
    private Pane rootPane;
    @FXML
    private Pane contentPane;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
 list = sp.afficher();
        loadData(list);
    }    
       public void loadData(List<Local> list) {
        int colmn = 0;
        int row = 1;
        nbPst.setText(list.size() + " posts ");
        try {
            for (Local place : list) {
                FXMLLoader loader = new FXMLLoader();
                loader.setLocation(getClass().getResource("LocalPane.fxml"));
                Pane pane = loader.load();
                LocalPaneController plc = loader.getController();
                plc.setData(place);
                System.out.println("colmn  "+colmn +" row  "+ row);
                if (colmn == 1) {
                    colmn = 0;
                    row++;
                }
                PlacesGrid.add(pane, colmn++, row);
                GridPane.setMargin(pane, new Insets(20));
            }
        } catch (IOException ex) {
            System.out.println(ex.getMessage());
        }

    }

    @FXML
    private void Search(ActionEvent event) throws IOException {
        filterdlist= sp.afficher();
        Local james = filterdlist.stream()
  .filter(customer -> SearchByMe.getText().equals(customer.getLocalisation()))
  .findAny()
  .orElse(null);
        if (!(james == null)){
          filterdlist.clear();
         FXMLLoader loader = new FXMLLoader(getClass().getResource("LocalPane.fxml"));
            Parent parent = loader.load();

            LocalPaneController plc = (LocalPaneController) loader.getController();
                plc.setData(james);
            Stage stage = new Stage(StageStyle.DECORATED);
            stage.setTitle("Location");
            stage.setScene(new Scene(parent));
            stage.show();
        }
        else{
            JOptionPane.showMessageDialog(null, SearchByMe.getText()+" Dosen't exist");

        }
    }
    private Stage getStage() {
        return (Stage) PlacesGrid.getScene().getWindow();
    }    @FXML
    private void Export(ActionEvent event) {
                        List<List> printData = new ArrayList<>();
        String[] headers = {"   Nom Bloc   ", "  Nom Patient  ", "  Nom Medecin  ", "  Localisation " };
        printData.add(Arrays.asList(headers));
        for (Local place : list) {
            List<String> row = new ArrayList<>();
            row.add(place.getNom_block());
            row.add(place.getNom_patient());
            row.add(place.getNom_medecin());
            row.add(place.getLocalisation());
            printData.add(row);
        }
            Util.initPDFExprot( contentPane, getStage(), printData);
    }
    }

