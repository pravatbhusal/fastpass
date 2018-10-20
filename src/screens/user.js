import React from "react";
import Icon from 'react-native-vector-icons/FontAwesome';
import {StyleSheet, Text, View, Image, TouchableOpacity} from "react-native";

class User extends React.Component {
  // stack navigator's page settings
  static navigationOptions = {
  	header: null,
    title: "User"
  }
  render() {
    // stack navigator's navigation object
    var {navigate} = this.props.navigation;
    return (
      <View>
        <Text>Hello World</Text>
      </View>
    );
  }
}

// style sheet for the Home Component
const styles = StyleSheet.create({
});

export default User;
