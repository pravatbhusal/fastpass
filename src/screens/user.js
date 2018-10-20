import React from "react";
import {serverURL} from "../../App";
import Icon from 'react-native-vector-icons/FontAwesome';
import {StyleSheet, Text, View, Image, TouchableOpacity} from "react-native";

class User extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      faceImage: "Connecting to server...",
      faceSimilarity: "Connecting to server...",
      email: "Connecting to server...",
      aadvantageId: "Connecting to server...",
      firstName: "Connecting to server...",
      lastName: "Connecting to server...",
      gender: "Connecting to server...",
      flightNumber: "Connecting to server...",
      aircraftType: "Connecting to server...",
      origin: "Connecting to server...",
      destination: "Connecting to server...",
      boardingTime: "Connecting to server...",
      departureTime: "Connecting to server...",
      arrivalTime: "Connecting to server...",
      date: "Connecting to server...",
      seat: "Connecting to server...",
      cost: "Connecting to server..."
    }
  }

  // stack navigator's page settings
  static navigationOptions = {
  	header: null,
    title: "User"
  }

  componentWillMount() {
    this.setUserData();
  }

  // set the data of the customer
  setUserData() {
    // grab the customer's JSON data processed by the server
    let {params} = this.props.navigation.state;
    let data = JSON.parse(params.data);

    // update state
    this.setState({faceImage: data.faceImage});
    this.setState({email: data.email});
    this.setState({aadvantageId: data.aadvantageId});
    this.setState({firstName: data.firstName});
    this.setState({lastName: data.lastName});
    this.setState({gender: data.gender});
    this.setState({flightNumber: data.flightNumber});
    this.setState({aircraftType: data.aircraftType});
    this.setState({origin: data.origin});
    this.setState({destination: data.destination});
    this.setState({boardingTime: data.boardingTime});
    this.setState({departureTime: data.departureTime});
    this.setState({arrivalTime: data.arrivalTime});
    this.setState({date: data.date});
    this.setState({seat: data.seat});
    this.setState({cost: data.cost});
  }
  render() {
    return (
      <View style={styles.container}>
        <Text>Hello World</Text>
      </View>
    );
  }
}

// style sheet for the Home Component
const styles = StyleSheet.create({
  container: {
    flex: 1,
    flexDirection: "column",
    alignItems: "center"
  }
});

export default User;
