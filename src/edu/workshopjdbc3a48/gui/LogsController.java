/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package edu.workshopjdbc3a48.gui;

import edu.workshopjdbc3a48.entities.Log;
import edu.workshopjdbc3a48.entities.Utilisateur;
import edu.workshopjdbc3a48.services.ServiceLog;
import edu.workshopjdbc3a48.services.ServiceUtilisateur;
import java.io.IOException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.Stage;
import javafx.util.Callback;

/**
 * FXML Controller class
 *
 * @author user
 */
public class LogsController implements Initializable {

    @FXML
    private TableColumn<?, ?> nom_l;
    @FXML
    private TableColumn<?, ?> type_l;
    @FXML
    private TableColumn<?, ?> date_l;
    @FXML
    private TableColumn<Log, String> col_l;
    @FXML
    private TableView<Log> tab_logs;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        ServiceLog su = new ServiceLog();
        List<Log> list= new ArrayList<>();// TODO
        list=su.getAll();
       
         ObservableList<Log> observableList = FXCollections.observableArrayList(list);
    tab_logs.setItems(observableList);
        col_l.setCellFactory(new Callback<TableColumn<Log, String>, TableCell<Log, String>>() {
    @Override
    public TableCell<Log, String> call(TableColumn<Log, String> col) {
        final TableCell<Log, String> cell = new TableCell<Log, String>() {
            final Button btn = new Button("Supprimer");
            
              @Override
              
            public void updateItem(String item, boolean empty) {
              
                {
                    setGraphic(btn);
                }
            }
            {
                btn.setOnAction((ActionEvent event) -> {
                    Log l = getTableView().getItems().get(getIndex());
                    ServiceLog sl = new ServiceLog();
                    sl.supprimer(l.getId_log());
                    update();
                });
            }
          
        };
        return cell;
    }
}); 
 nom_l.setCellValueFactory(new PropertyValueFactory<>("nom"));
     type_l.setCellValueFactory(new PropertyValueFactory<>("Type"));
      date_l.setCellValueFactory(new PropertyValueFactory<>("Date"));
  
 tab_logs.getSelectionModel().selectedItemProperty().addListener((observable, oldValue, newValue) -> {
  
   
            Log selectedLog = newValue;
            System.out.println(selectedLog);
            FXMLLoader loader = new FXMLLoader(getClass().getResource("ModifierLog.fxml"));
            Parent root = null;
            try {
                root = loader.load();
            } catch (IOException ex) {
                Logger.getLogger(AfficherUserController.class.getName()).log(Level.SEVERE, null, ex);
            }
           ModifierLogController controller = loader.getController();
            controller.setUs(selectedLog);
            controller.setFirstInterface(this);
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
          stage.show();
         Stage stage1 = (Stage) tab_logs.getScene().getWindow(); // get the current stage
         System.out.println(stage1);
  //  stage1.close();
    });
// TODO
    }    
     public void update(){
    ServiceLog su = new ServiceLog();
        List<Log> list= new ArrayList<>();// TODO
        list=su.getAll();
        System.out.println(list.get(0));
         ObservableList<Log> observableList = FXCollections.observableArrayList(list);
    tab_logs.setItems(observableList);
  
  tab_logs.refresh();
  }
}
